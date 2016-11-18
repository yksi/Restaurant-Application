<?php

namespace Application\Controller;

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
     * @param \Zend\Mvc\MvcEvent $e
     * @return mixed
     */
    public function onDispatch( \Zend\Mvc\MvcEvent $e )
    {
        $e->getViewModel()->setVariable('user', $this->getUser());

        return parent::onDispatch( $e );
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