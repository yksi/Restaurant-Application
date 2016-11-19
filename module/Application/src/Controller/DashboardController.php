<?php

namespace Application\Controller;

use Application\Aware\Order;
use Application\Service\AbstractService;
use DateTime;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Application\Controller
 */
class DashboardController extends AbstractController
{

    /**
     * @param MvcEvent $event
     * @return mixed
     */
    public function onDispatch(MvcEvent $event)
    {
        if (null === $this->getUser()) {
            $this->redirect()->toRoute('auth', ['action' => 'login']);
        }

        return parent::onDispatch($event);
    }

    /**
     * Main action
     */
    public function indexAction()
    {
        $view = true === $this->getRequest()->isXmlHttpRequest() ? new JsonModel() : new ViewModel();

        try {

            $service = AbstractService::factory($this->getUser()->getRole());
            $service->setEntityManager($this->getEntityManager());
            $service->setOptions(
                [
                    AbstractService::OPTION_STATUS => $this->getRequest()->getQuery('status', \Application\Entity\Order::STATUS_NEW),
                    AbstractService::OPTION_USER => $this->getUser(),

                ]
            );

            $renderer = $this->getEvent()->getApplication()->getServiceManager()->get('Zend\View\Renderer\PhpRenderer');

            if (false === fsockopen('soft-group-test.dev', 8080)) {
                $server = IoServer::factory(new HttpServer(new WsServer($service)), 8080);
                $server->run();
            }

            $view->setVariables(
                [
                    'dashboard' => $renderer->render((new ViewModel($service->getVariables()))->setTemplate($service->getView()))//$partial($service->getView(), $service->getVariables())
                ]
            );
        } catch (\Exception $exception) {
            $view->setVariables(
                [
                    'errors' => [
                        $exception->getMessage()
                    ]
                ]
            );
        }

        return $view;
    }

    /**
     * Order create and update action
     */
    public function orderAction()
    {
        if ($this->getRequest()->isPost()) {
            $form = new Order('order');
            $form->setData($this->getRequest()->getPost()->toArray());

            if (true === $form->isValid()) {

                if (null === ($id = $this->getRequest()->getPost('id'))) {
                    $order = new \Application\Entity\Order();
                    $order->setWaiter($this->getUser());
                } else {
                    $order = $this->getEntityManager()->find(\Application\Entity\Order::class, $id);

                    if (null === $order) {
                        return new ViewModel(
                            [
                                'errors' => [
                                    'Can not update order'
                                ]
                            ]
                        );
                    }
                }

                $order->setName($form->get('name')->getValue());
                $order->setDish($form->get('dish')->getValue());
                $order->setCreated(new DateTime());
                $order->setStatus($this->getRequest()->getPost('status', \Application\Entity\Order::STATUS_NEW));

                if (false === empty($this->getRequest()->getPost('minutes'))) {

                    if ($this->getUser()->getRole() === 'cook') {
                        $order->setCook($this->getUser());
                    }

                    $order->setMinutes($form->get('minutes')->getValue());
                }

                $this->getEntityManager()->persist($order);
                $this->getEntityManager()->flush($order);

                $this->redirect()->toRoute('home');
            } else {
                return new ViewModel([
                    'errors' => $form->getMessages()
                ]);
            }
        }

        return new ViewModel();
    }

}