<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Account;

class AccountFixtures extends AbstractDataFixture
{
    const ACCOUNTS_COUNT = 10;

    protected function createAndPersistData()
    {
        for ($i = 1; $i <= self::ACCOUNTS_COUNT; $i++) {
            $account = new Account();
            $account->setActive(true);
            $account->setEmail(sprintf('email%s@email.com', $i));
            $account->setPassword('password');
            $this->manager->persist($account);
            $this->setReference(sprintf('account_%s', $i), $account);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}