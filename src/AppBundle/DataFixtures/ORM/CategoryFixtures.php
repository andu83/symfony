<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;

class CategoryFixtures extends AbstractDataFixture
{
    private $categoriesCount = 0;
    private $categories = array('computers'          => array('servers', 'desktop', 'laptops', 'components', 'periferals'),
                                'phones and tablets' => array('phones', 'tablets', 'accessories'),
                                'appliances'         => array('coffe machines', 'washing machines', 'blenders', 'juicers'),
                                'video games'        => array('consoles', 'games', 'accessories')
    );

    protected function createAndPersistData()
    {
        foreach ($this->categories as $parent => $children) {
            $parentCategory = $this->createAndPersistCategory($parent);
            foreach ($children as $label) {
                $this->createAndPersistCategory($label, $parentCategory);
            }
        }
    }

    private function createAndPersistCategory($label, $parentCategory = null)
    {
        $this->categoriesCount++;
        $category = new Category();
        $category->setLabel($label)->setParentCategory($parentCategory);
        $this->manager->persist($category);
        $this->setReference(sprintf('category_%s', $this->categoriesCount), $category);

        return $category;
    }

    public function getOrder()
    {
        return 1;
    }
}