<?php

namespace Application;

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
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

}