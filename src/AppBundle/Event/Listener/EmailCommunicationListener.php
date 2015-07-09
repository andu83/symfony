<?php
namespace AppBundle\Event\Listener;

use AppBundle\Communication\Email\Message;
use AppBundle\Document\Email;
use AppBundle\Event\Communication\Email\EmailEvent;
use AppBundle\Event\Communication\Email\EmailSendingEvent;
use Doctrine\Bundle\MongoDBBundle\ManagerRegistry;
use Doctrine\ODM\MongoDB\DocumentManager;

class EmailCommunicationListener
{
    /**     *     * @var DocumentManager */
    private $documentManager;

    public function __construct(ManagerRegistry $registry)
    {
        $this->documentManager = $registry->getManager();
    }

    public function onBeforeSend(EmailEvent $event)
    {
    }

    public function onEmailSent(EmailSendingEvent $event)
    {
        $this->persistEmailMessage($event->getMessage(), $event->getType(), Email::STATUS_SENT, $event->getArguments());
    }

    public function onTemporaryError(EmailEvent $event)
    {
        $this->persistEmailMessage($event->getMessage(), $event->getType(), Email::STATUS_TEMPORARY_ERROR, $event->getArguments());
    }

    public function onPermanentError(EmailEvent $event)
    {
        $this->persistEmailMessage($event->getMessage(), $event->getType(), Email::STATUS_PERMANENT_ERROR, $event->getArguments());
    }

    private function persistEmailMessage(Message $message, $type, $status, $arguments)
    {
        $email = new Email();
        $email->setType($type);
        $email->setBody($message->getMessage());
        $email->setEmailAddress($message->getTo());
        $email->setFrom($message->getFrom());
        $email->setSubject($message->getSubject());
        $email->setArguments($arguments);
        $email->setStatus($status);
        $this->documentManager->persist($email);
        $this->documentManager->flush();
    }
}