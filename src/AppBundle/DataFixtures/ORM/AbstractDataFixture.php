<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

abstract class AbstractDataFixture extends AbstractFixture implements OrderedFixtureInterface
{
    /**     *     * @var ObjectManager */
    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;
        $this->createAndPersistData();
        $this->manager->flush();
    }

    abstract protected function createAndPersistData();

    protected function getReferences($prefix)
    {
        $entities = array();
        for ($i = 1; true; $i++) {
            try {
                $entities[] = $this->getReference(sprintf('%s_%s', $prefix, $i));
            } catch (\OutOfBoundsException $exception) {
                break;
            }
        }

        return $entities;
    }
}