<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Country;

class CountryFixtures extends AbstractDataFixture
{
    private $countries = array('en' => 'england', 'es' => 'spain', 'fr' => 'france', 'it' => 'italy', 'ro' => 'romania', 'tn' => 'tunisia',);

    protected function createAndPersistData()
    {
        foreach ($this->countries as $countryCode => $name) {
            $country = new Country();
            $country->setCode($countryCode)->setName($name);
            $this->manager->persist($country);
        }
    }

    public function getOrder()
    {
        return 1;
    }
}