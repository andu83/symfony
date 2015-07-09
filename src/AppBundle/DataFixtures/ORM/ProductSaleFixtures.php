<?php namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\ProductSale;

class ProductSaleFixtures extends AbstractDataFixture
{
    protected function createAndPersistData()
    {
        foreach ($this->getReferences('product') as $product) {
            $productSale = new ProductSale();
            $productSale->setProduct($product)->setActive(rand(0, 1));
            $productSale->setPrice(rand(100, 10000));
            $randomDate = time() + rand(-100000, 100000);
            $startDate  = new \DateTime();
            $startDate->setTimestamp($randomDate);
            $endDate = new \DateTime();
            $endDate->setTimestamp($randomDate + rand(100000, 1000000));
            $productSale->setStartDate($startDate)->setEndDate($endDate);
            $this->manager->persist($productSale);
        }
    }

    public function getOrder()
    {
        return 3;
    }
}