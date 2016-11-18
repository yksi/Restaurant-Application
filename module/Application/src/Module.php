<?php

namespace Application;
use Zend\Authentication\AuthenticationService;

/**
 * Class Module
 * @package Application
 */
class Module
{
    /**
     * Module Version
     */
    const VERSION = 'beta';

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'factories'=> [
                'Application\Storage\Storage' => function($serviceManager) {
                    $storage = new \Application\Storage\Storage('restaurant');
                    $storage->setEntityManager($serviceManager->get('Doctrine\ORM\EntityManager'));

                    return $storage;
                },

                'AuthService' => function($serviceManager) {
                    $authService = new AuthenticationService();
                    $authService->setStorage($serviceManager->get('Application\Storage\Storage'));

                    return $authService;
                },
            ],
        ];
    }

}