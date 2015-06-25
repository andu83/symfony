<?php
namespace AppBundle\Communication\Email;

class PhpProvider implements ProviderInterface
{
    public function send(Message $message)
    {
        return mail(
            $message->getTo(),
            $message->getSubject(),
            $message->getMessage(),
            $message->getAdditionalHeaders(),
            $message->getAdditionalParameters()
        );
    }
}