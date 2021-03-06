<?php

namespace Application\Service;
use Application\Entity\Order;
use Doctrine\Common\Collections\Criteria;

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
        $orderRepository = $this->getEntityManager()->getRepository(Order::class);

        $orders = $orderRepository->matching(
            (new Criteria())->where(Criteria::expr()->neq('status', Order::STATUS_CLOSED))
                ->andWhere(Criteria::expr()->eq('waiter', $this->getOption(static::OPTION_USER)))
                ->orderBy(
                    [
                        'created' => 'DESC'
                    ]
                )
        )->toArray();

        return [
            'orders' => $orders
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