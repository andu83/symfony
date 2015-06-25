<?php
namespace AppBundle\Event\Order;

use AppBundle\Entity\Order;

class OrderAfterCreate extends OrderEvent
{
    /**     *     * @var Order */
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }
}
