<?php

namespace Application\Service;
use Application\Entity\Order;
use Application\Entity\Repository\OrderRepository;

/**
 * Class Waiter
 * @package Application\Service
 */
class Waiter extends AbstractService
{
    /**
     * @return array
     */
    public function getVariables()
    {
        /** @var OrderRepository $orderRepository */
        $orderRepository = $this->getEntityManager()->getRepository(Order::class);

        $orders = $orderRepository->getOrdersByWaiter($this->getOption(static::OPTION_USER));

        return [
            'orders' => array_filter(
                $orders,
                function ($order) {
                    /** @var Order $order */
                    return $this->getOption(static::OPTION_STATUS) === $order->getStatus();
                }
            )
        ];
    }

    /**
     * @return string
     */
    function getView()
    {
        return 'partial/index/waiter.phtml';
    }


}