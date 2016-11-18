<?php

namespace Application\Entity\Repository;

use Application\Entity\Order;
use Application\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * Class OrderRepository
 * @package Application\Entity\Repository
 */
class OrderRepository extends EntityRepository
{

    /**
     * @return array
     */
    public function getActiveOrders()
    {
        return $this->findBy(
            [
                'status' => Order::STATUS_NEW
            ]
        );
    }

    /**
     * @param User $user
     * @return array
     */
    public function getOrdersByWaiter(User $user)
    {
        return $this->findBy(
            [
                'waiter' => $user
            ]
        );
    }

}