<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\Technique;

class LoadTechniqueData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new Technique();
        $entity1->setName("fixTechnique1")->setDescription("a")->setUrl("a.url");
        $em->persist($entity1);
        $this->addReference('fixTechnique1', $entity1);

        $entity2 = new Technique();
        $entity2->setName("fixTechnique2")->setDescription("b")->setUrl("b.url");
        $em->persist($entity2);
        $this->addReference('fixTechnique2', $entity2);

        $entity3 = new Technique();
        $entity3->setName("fixTechnique3")->setDescription("c")->setUrl("c.url");
        $em->persist($entity3);
        $this->addReference('fixTechnique3', $entity3);

        $em->flush();
        self::$members = array($entity1, $entity2, $entity3);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 9;
    }
}
