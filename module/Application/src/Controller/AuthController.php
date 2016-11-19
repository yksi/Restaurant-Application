<?php

namespace Application\Controller;

use Application\Auth\Adapter;
use Application\Aware\Login;
use Application\Aware\Register;
use Application\Entity\User;
use Zend\Authentication\Result;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;

/**
 * Class AuthController
 * @package Application\Controller
 */
class AuthController extends AbstractController
{

    /**
     * @param MvcEvent $event
     * @return mixed
     */
    public function onDispatch(MvcEvent $event)
    {
        if (null !== $this->getUser()) {
            $this->redirect()->toRoute('home');
        }

        return parent::onDispatch($event);
    }

    /**
     * Login action
     */
    public function loginAction()
    {
        if (true === $this->getRequest()->isPost()) {

            $form = new Login('register');
            $form->setData($this->getRequest()->getPost()->toArray());

            if (true === $form->isValid()) {
                $adapter = new Adapter(
                    $form->get('email')->getValue(),
                    $form->get('password')->getValue(),
                    $this->getEntityManager()
                );

                $result = $adapter->authenticate();

                if ($result->getCode() === Result::SUCCESS) {
                    $this->getAuthService()->getStorage()->write($result->getIdentity());

                    $this->redirect()->toRoute('home');
                }
            }
        }

        return new ViewModel();
    }

    /**
     * Login action
     */
    public function logoutAction()
    {
        if (false === $this->getAuthService()->getStorage()->isEmpty()) {
            $this->getAuthService()->getStorage()->clear();
        }

        $this->redirect()->toRoute('auth', ['action' => 'login']);
    }

    /**
     * Register action
     */
    public function registerAction()
    {
        if (true === $this->getRequest()->isPost()) {

            $form = new Register('register');
            $form->setData($this->getRequest()->getPost()->toArray());

            if (true === $form->isValid()
                && null === $this->getEntityManager()->getRepository(User::class)->findOneBy(['email' => $form->get('email')->getValue()])
            ) {
                $user = new User();

                $user->setEmail($form->get('email')->getValue());
                $user->setName($form->get('name')->getValue());
                $user->setPassword($form->get('password')->getValue());
                $user->setRole($form->get('role')->getValue());
                $user->setActive(true);

                $this->getEntityManager()->persist($user);
                $this->getEntityManager()->flush($user);

                $adapter = new Adapter($user->getEmail(), $form->get('password')->getValue(), $this->getEntityManager());
                $result = $adapter->authenticate();

                if ($result->getCode() === Result::SUCCESS) {
                    $this->getAuthService()->getStorage()->write($user->getId());
                    $this->redirect()->toRoute('home');
                }
            }
        }

        return new ViewModel();
    }
}