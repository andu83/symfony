<?php

namespace AppBundle\Service;

use AppBundle\Entity\Order;
use AppBundle\Entity\ProductStock;
use AppBundle\Entity\Warehouse;

class WarehouseService extends AbstractDoctrineAware
{

    const ID = 'app.warehouse';

    public function getAll()
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('warehouse')
            ->from(Warehouse::REPOSITORY, 'warehouse')
            ->getQuery()
            ->getArrayResult();
    }

    public function getOne()
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('warehouse')
            ->from(Warehouse::REPOSITORY, 'warehouse')
            ->getQuery()
            ->setMaxResults(1)
            ->getArrayResult();
    }

    public function getProductStocks($productId)
    {
        $stocks = $this->entityManager->getRepository(ProductStock::REPOSITORY)
            ->findBy(array('product' => $productId));
        if (empty($stocks)) {
            $this->logger->addNotice(sprintf('No stocks found for product %s', $productId));
        }

        return $stocks;
    }

    public function reserveProducts(Order $order) {
    }

}
