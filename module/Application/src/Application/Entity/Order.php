<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * @ORM\Entity(repositoryClass="Application\Entity\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{

    /**
     * Order statuses
     */
    const STATUS_NEW  = 'new';
    const STATUS_WAIT = 'wait';
    const STATUS_DONE = 'done';
    const STATUS_FAIL = 'fail';

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="cook_id", referencedColumnName="id")
     */
    private $cook;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(name="waiter_id", referencedColumnName="id")
     */
    private $waiter;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $dish;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $minutes;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return User
     */
    public function getCook(): User
    {
        return $this->cook;
    }

    /**
     * @return User
     */
    public function getWaiter(): User
    {
        return $this->waiter;
    }

    /**
     * @return string
     */
    public function getDish(): string
    {
        return $this->dish;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @return int
     */
    public function getMinutes(): int
    {
        return $this->minutes;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param User $cook
     */
    public function setCook(User $cook)
    {
        $this->cook = $cook;
    }

    /**
     * @param User $waiter
     */
    public function setWaiter(User $waiter)
    {
        $this->waiter = $waiter;
    }

    /**
     * @param string $dish
     */
    public function setDish(string $dish)
    {
        $this->dish = $dish;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @param int $minutes
     */
    public function setMinutes(int $minutes)
    {
        $this->minutes = $minutes;
    }
}