<?php

namespace Application\Controller;

use Application\Aware\Order;
use Application\Service\AbstractService;
use DateTime;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 * @package Application\Controller
 */
class DashboardController extends AbstractController
{

    /**
     * Main action
     */
    public function indexAction()
    {
        $view = new ViewModel();

        try {
            $service = AbstractService::factory($this->getUser()->getRole());
            $service->setEntityManager($this->getEntityManager());
            $service->setOptions(
                [
                    AbstractService::OPTION_STATUS => $this->params('status', \Application\Entity\Order::STATUS_NEW),
                    AbstractService::OPTION_USER => $this->getUser(),

                ]
            );

            $renderer = $this->getEvent()->getApplication()->getServiceManager()->get('Zend\View\Renderer\PhpRenderer');

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
     *
     */
    public function orderAction()
    {
        if ($this->getRequest()->isPost()) {
            $form = new Order('order');
            $form->setData($this->getRequest()->getPost()->toArray());

            if (true === $form->isValid()) {
                $order = new \Application\Entity\Order();
                $order->setWaiter($this->getUser());
                $order->setName($form->get('name')->getValue());
                $order->setDish($form->get('dish')->getValue());
                $order->setCreated(new DateTime());
                $order->setStatus(\Application\Entity\Order::STATUS_NEW);

                $this->getEntityManager()->persist($order);
                $this->getEntityManager()->flush($order);

                $this->redirect()->toRoute('home');
            }
        }

        return new ViewModel();
    }

}