<?php
namespace AppBundle\Event\Order;

use Symfony\Component\EventDispatcher\Event;

class OrderEvent extends Event
{
    const BEFORE_CREATE = 'order.before_create';
    const AFTER_CREATE = 'order.after_create';
    const PRODUCTS_RESERVED = 'order.products_reserver';
}
