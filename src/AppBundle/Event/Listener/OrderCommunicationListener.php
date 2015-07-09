<?php

namespace AppBundle\Event\Listener;

use AppBundle\Event\Order\OrderEvent;
use AppBundle\Service\Communication\CommunicationService;

class OrderCommunicationListener
{

    /**
     *
     * @var CommunicationService
     */
    private $communicationService;

    public function __construct(CommunicationService $communicationService)
    {
        $this->communicationService = $communicationService;
    }

    public function onAfterCreate(OrderEvent $event)
    {
        $emailAddress = $this->getEmailAddress($event);
        $customerName = $this->getCustomerName($event);
        $this->communicationService->sendConfirmationEmail($emailAddress, $customerName, $event->getOrder()->getId());
    }

    private function getCustomerName(OrderEvent $event)
    {
        return $event->getOrder()->getCustomer()->getContact()->getName();
    }

    public function onInvoiceGenerated(OrderEvent $event)
    {
        $emailAddress = $this->getEmailAddress($event);
        $this->communicationService->sendInvoice($emailAddress, $event->getOrder()->getId());
    }

    public function onDeliveryStart(OrderEvent $event)
    {
        $emailAddress = $this->getEmailAddress($event);
        $this->communicationService->sendDeliveryEmail($emailAddress, $event->getOrder()->getId());
    }

    public function onDeliveryEnd(OrderEvent $event)
    {
        $emailAddress = $this->getEmailAddress($event);
        $this->communicationService->sendSatisfactionSurvey($emailAddress, $event->getOrder()->getId());
    }

    private function getEmailAddress(OrderEvent $event)
    {
        return $event->getOrder()->getCustomer()->getContact()->getEmail();
    }

}
