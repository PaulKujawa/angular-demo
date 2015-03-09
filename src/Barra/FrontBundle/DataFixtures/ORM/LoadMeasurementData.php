<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\Measurement;

class LoadMeasurementData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new Measurement();
        $entity1->setGr(1)->setType("gr");
        $em->persist($entity1);
        $this->addReference('fixMeasurement1', $entity1);

        $entity2 = new Measurement();
        $entity2->setGr(15)->setType("el");
        $em->persist($entity2);
        $this->addReference('fixMeasurement2', $entity2);

        $entity3 = new Measurement();
        $entity3->setGr(1)->setType("ml");
        $em->persist($entity3);
        $this->addReference('fixMeasurement3', $entity3);

        $em->flush();
        self::$members = array($entity1, $entity2, $entity3);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
