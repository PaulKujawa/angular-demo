<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\Recipe;

class LoadRecipeData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new Recipe();
        $entity1->setName("fixRecipe1");
        $em->persist($entity1);
        $this->addReference('fixRecipe1', $entity1);

        $entity2 = new Recipe();
        $entity2->setName("fixRecipe2");
        $em->persist($entity2);
        $this->addReference('fixRecipe2', $entity2);

        $entity3 = new Recipe();
        $entity3->setName("fixRecipe3");
        $em->persist($entity3);
        $this->addReference('fixRecipe3', $entity3);

        $em->flush();
        self::$members = array($entity1, $entity2, $entity3);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
