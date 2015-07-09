<?php
namespace AppBundle\Event\Communication\Email;

use AppBundle\Event\LoggableEventInterface;
use Symfony\Component\EventDispatcher\Event;

class EmailEvent extends Event implements LoggableEventInterface
{
    const BEFORE_SEND = 'email.before_send';
    const ERROR_TEMPORARY = 'email.error_temporary';
    const ERROR_PERMANENT = 'email.error_permanent';
    const SENT = 'email.sent';
    const RESEND = 'email.resend';

    private $type;
    private $emailAddress;
    private $arguments;

    public function __construct($type, $emailAddress, $arguments)
    {
        $this->type         = $type;
        $this->emailAddress = $emailAddress;
        $this->arguments    = $arguments;
    }

    public function getLogContext()
    {
        return array('type' => $this->type, 'emailAddress' => $this->emailAddress, 'arguments' => $this->arguments,);
    }

    public function getType()
    {
        return $this->type;
    }

    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    public function getArguments()
    {
        return $this->arguments;
    }
}