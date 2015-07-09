<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Contact;

class ContactFixtures extends AbstractDataFixture
{
    const CONTACTS_COUNT = 10;

    protected function createAndPersistData()
    {
        for ($i = 1; $i <= self::CONTACTS_COUNT; $i++) {
            $contact = new Contact();
            $contact->setName(sprintf('contact %s', $i));
            $contact->setEmail(sprintf('contact_email%s@email.com', $i));
            $contact->setMobilePhone(rand(1111111111, 9999999999));
            $contact->setPhone(rand(1111111111, 9999999999));
            $this->manager->persist($contact);
            $this->setReference(sprintf('contact_%s', $i), $contact);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}