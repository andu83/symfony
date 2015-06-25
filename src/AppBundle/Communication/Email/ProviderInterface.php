<?php
namespace AppBundle\Communication\Email;

interface ProviderInterface
{
    public function send(Message $message);
}
