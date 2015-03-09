<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\Agency;

class LoadAgencyData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new Agency();
        $entity1->setName("fixAgency1")->setUrl("a.com");
        $em->persist($entity1);
        $this->addReference('fixAgency1', $entity1);

        $entity2 = new Agency();
        $entity2->setName("fixAgency2")->setUrl("b.com");
        $em->persist($entity2);
        $this->addReference('fixAgency2', $entity2);

        $entity3 = new Agency();
        $entity3->setName("fixAgency3")->setUrl("c.com");
        $em->persist($entity3);
        $this->addReference('fixAgency3', $entity3);

        $em->flush();
        self::$members = array($entity1, $entity2, $entity3);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 8;
    }
}
