<?php

namespace Application\Service;
use Application\Entity\Order;
use Doctrine\Common\Collections\Criteria;

/**
 * Class Waiter
 * @package Application\Service
 */
class Cook extends AbstractService
{
    /**
     * @return array
     */
    public function getVariables()
    {
        $orderRepository = $this->getEntityManager()->getRepository(Order::class);

        $newOrders = $orderRepository->matching(
            (new Criteria())->where(Criteria::expr()->eq('status', Order::STATUS_NEW))
                ->orderBy(
                    [
                        'created' => 'DESC'
                    ]
                )
        )->toArray();

        $myOrders = $orderRepository->matching(
            (new Criteria())->where(Criteria::expr()->neq('status', Order::STATUS_CLOSED))
                ->andWhere(Criteria::expr()->neq('status', Order::STATUS_NEW))
                ->andWhere(Criteria::expr()->eq('cook', $this->getOption(static::OPTION_USER)))
                ->orderBy(
                    [
                        'created' => 'DESC'
                    ]
                )
        )->toArray();

        return [
            'orders' => array_merge($newOrders, $myOrders)
        ];
    }

    /**
     * @return string
     */
    function getView()
    {
        return 'partial/index/cook.phtml';
    }


}