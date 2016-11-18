<?php

namespace Application\Service;
use Doctrine\ORM\EntityManager;

/**
 * Class AbstractService
 * @package Application\Service
 */
abstract class AbstractService
{

    /**
     * Options
     */
    const OPTION_USER   = 'user';
    const OPTION_STATUS = 'status';

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param string $name
     * @param null $default
     * @return mixed|null
     */
    public function getOption(string $name, $default = null)
    {
        return $this->options[$name] ?? $default;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $type
     * @return AbstractService
     * @throws \Exception
     */
    public static function factory(string $type)
    {
        $service = 'Application\Service\\' . ucfirst($type);

        if (false === class_exists($service)) {
            throw new \Exception('Class ' . $service . ' does not exists');
        }

        return new $service();
    }

    /**
     * @return array
     */
    abstract function getVariables();

    /**
     * @return string
     */
    abstract function getView();
}