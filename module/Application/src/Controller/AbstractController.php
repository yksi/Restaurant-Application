<?php

namespace Application\Controller;

use Zend\Mvc\MvcEvent;
use Application\Entity\User;
use Doctrine\ORM\EntityManager;
use Zend\Authentication\AuthenticationService;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Class AbstractController
 * @package Application\Controller
 *
 * @method Request getRequest()
 */
abstract class AbstractController extends AbstractActionController
{

    /**
     * @param MvcEvent $event
     * @return mixed
     */
    public function onDispatch(MvcEvent $event)
    {
        $event->getViewModel()->setVariable('user', $this->getUser());

        return parent::onDispatch($event);
    }

    /**
     * @return EntityManager mixed
     */
    public function getEntityManager()
    {
        return $this->getEvent()->getApplication()->getServiceManager()->get('Doctrine\ORM\EntityManager');
    }

    /**
     * @return AuthenticationService
     */
    public function getAuthService()
    {
        return $this->getEvent()->getApplication()->getServiceManager()->get('AuthService');
    }

    /**
     * @return null|User
     */
    public function getUser()
    {
        return $this->getAuthService()->getStorage()->read();
    }

}