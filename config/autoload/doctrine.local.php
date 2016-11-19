<?php

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' =>'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => '',
                    'dbname'   => 'development',
                    'encoding' => 'utf8',
                ]
            ]
        ],
        'configuration' => [
            'orm_default' => [
                'proxy_dir' => 'data/proxy',
                'proxy_namespace' => 'Doctrine\Proxy',
            ]
        ],
        'migrations_configuration' => array(
            'orm_default' => array(
                'directory' => 'config/database/migrations',
                'namespace' => 'Migrations',
                'table' => 'migrations',
            ),
        ),
        'driver' => [
            'application_entities' => [
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => ['module/Application/src/Application/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => 'application_entities',
                ],
            ],
        ],
    ]
];