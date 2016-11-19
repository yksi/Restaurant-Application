<?php

namespace Application\Service;
use Doctrine\ORM\EntityManager;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

/**
 * Class AbstractService
 * @package Application\Service
 */
abstract class AbstractService implements MessageComponentInterface
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
     * @var \SplObjectStorage
     */
    protected $clients;

    /**
     * AbstractService constructor.
     */
    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

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

    /**
     * @param ConnectionInterface $from
     * @param string $message
     */
    function onMessage(ConnectionInterface $from, $message)
    {
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send('render');
            }
        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
    }

    /**
     * @param ConnectionInterface $conn
     */
    function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
    }

    /**
     * @param ConnectionInterface $conn
     * @param \Exception $e
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
    }


}