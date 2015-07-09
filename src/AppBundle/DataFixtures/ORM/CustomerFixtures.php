<?php namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Customer;

class CustomerFixtures extends AbstractDataFixture
{
    protected function createAndPersistData()
    {
        $index = 0;
        foreach ($this->getReferences('account') as $account) {
            $index++;
            $contact  = $this->getReference(sprintf('contact_%s', $index));
            $customer = new Customer();
            $customer->setAccount($account)->setContact($contact);
            $this->manager->persist($customer);
        }
    }

    public function getOrder()
    {
        return 2;
    }
}
