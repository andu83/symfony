<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Warehouse;

class WarehouseFixtures extends AbstractDataFixture
{
    protected function createAndPersistData()
    {
        for ($i = 1; $i <= 10; $i++) {
            $warehouse = new Warehouse();
            $warehouse->setName(sprintf('warehouse_%s', $i));
            $warehouse->setAddress(sprintf('warehouse address %s', $i));
            $this->manager->persist($warehouse);
            $this->setReference(sprintf('warehouse_%s', $i), $warehouse);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}
