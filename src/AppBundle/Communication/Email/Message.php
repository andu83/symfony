<?php
namespace AppBundle\Communication\Email;

class Message
{
    private $to;
    private $subject;
    private $message;
    private $additionalHeaders;
    private $additionalParameters;

    public function getTo()
    {
        return $this->to;
    }
7.5 Configuration expressions
    public function getSubject()
    {
        return $this->subject;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getAdditionalHeaders()
    {
        return $this->additionalHeaders;
    }

    public function getAdditionalParameters()
    {
        return $this->additionalParameters;
    }

    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    public function setAdditionalHeaders($additionalHeaders)
    {
        $this->additionalHeaders = $additionalHeaders;

        return $this;
    }

    public function setAdditionalParameters($additionalParameters)
    {
        $this->additionalParameters = $additionalParameters;

        return $this;
    }
}