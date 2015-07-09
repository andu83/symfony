<?php

namespace AppBundle\Service\Communication;

use AppBundle\Communication\Email\Message;
use AppBundle\Communication\Email\ProviderInterface;

class EmailService
{

    const ID = 'app.email';

    private $providers = array();
    private $providerIndex = -1;

    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[] = $provider;
    }

    public function send(Message $message)
    {
        $this->incrementIndex();
        $provider = $this->providers[$this->providerIndex];

        return $provider->send($message);
    }

    private function incrementIndex()
    {
        $this->providerIndex++;
        if ($this->providerIndex > count($this->providers) - 1) {
            $this->providerIndex = 0;
        }
    }

}
