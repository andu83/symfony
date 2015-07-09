<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ProductStock;

class ProductStockFixtures extends AbstractDataFixture
{
    protected function createAndPersistData()
    {
        foreach ($this->getReferences('product') as $product) {
            $productStock = new ProductStock();
            $productStock->setProduct($product)->setQuantity(rand(0, 1000));
            $warehouse = $this->getReference(sprintf('warehouse_%s', rand(1, 10)));
            $productStock->setWarehouse($warehouse);
            $this->manager->persist($productStock);
        }
    }

    public function getOrder()
    {
        return 3;
    }
}
