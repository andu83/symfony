<?php
namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/** * @MongoDB\Document(db="app", collection="emails") */
class Email
{
    const REPOSITORY = 'AppBundle:Email';
    const STATUS_SENT = 1;
    const STATUS_TEMPORARY_ERROR = 2;
    const STATUS_PERMANENT_ERROR = 3;
    /**     * @MongoDB\Id */
    private $id;
    /**     * @MongoDB\String */
    private $type;
    /**     * @MongoDB\String */
    private $emailAddress;
    /**     * @MongoDB\String */
    private $from;
    /**     * @MongoDB\String */
    private $subject;
    /**     * @MongoDB\Bin */
    private $body;
    /**     * @MongoDB\Int */
    private $status;
    /**     * @MongoDB\Hash */
    private $arguments;

    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function setArguments($arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }
}
