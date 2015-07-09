<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Vendor;

class VendorFixtures extends AbstractDataFixture
{
    protected function createAndPersistData()
    {
        for ($i = 1; $i <= 10; $i++) {
            $vendor = new Vendor();
            $vendor->setName(sprintf('vendor_%s', $i));
            $this->manager->persist($vendor);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}