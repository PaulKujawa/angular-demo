<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\Manufacturer;

class LoadManufacturerData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new Manufacturer();
        $entity1->setName("fixManufacturer1")->setName("fixManufacturer1");
        $em->persist($entity1);
        $this->addReference('fixManufacturer1', $entity1);

        $entity2 = new Manufacturer();
        $entity2->setName("fixManufacturer2")->setName("fixManufacturer2");
        $em->persist($entity2);
        $this->addReference('fixManufacturer2', $entity2);

        $entity3 = new Manufacturer();
        $entity3->setName("fixManufacturer3")->setName("fixManufacturer3");
        $em->persist($entity3);
        $this->addReference('fixManufacturer3', $entity3);

        $em->flush();
        self::$members = array($entity1, $entity2, $entity3);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
