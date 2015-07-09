<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductFixtures extends AbstractDataFixture implements ContainerAwareInterface
{
    private $productsCount = 0;
    private $productsPerCategory;

    private function createAndPersistProducts(Category $category)
    {
        for ($i = 1; $i <= $this->productsPerCategory; $i++) {
            $this->productsCount++;
            $product = new Product();
            $product->setCode(sprintf('code_%s_%s', $category->getId(), $i))->setTitle(sprintf('title %s %s %s', $category->getId(), $i, uniqid()))
                ->setDescription(sprintf('product description %s', $i));
            $category->addProduct($product);
            $this->manager->persist($product);
            $this->setReference(sprintf('product_%s', $this->productsCount), $product);
        }
    }

    protected function createAndPersistData()
    {
        foreach ($this->getReferences('category') as $category) {
            $this->createAndPersistProducts($category);
        }
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $fixturesConfig            = $container->getParameter('fixtures');
        $this->productsPerCategory = $fixturesConfig['products_per_category'];
    }

    public function getOrder()
    {
        return 2;
    }
}