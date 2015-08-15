<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\Cooking;

class LoadCookingData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new Cooking();
        $entity1->setPosition(1)->setDescription("1st step")->setRecipe( $this->getReference('fixRecipe1') )->createId();
        $em->persist($entity1);
        $this->addReference('fixCooking1', $entity1);

        $entity2 = new Cooking();
        $entity2->setPosition(2)->setDescription("2nd step")->setRecipe( $this->getReference('fixRecipe1') )->createId();
        $em->persist($entity2);
        $this->addReference('fixCooking2', $entity2);

        $entity3 = new Cooking();
        $entity3->setPosition(3)->setDescription("3th step")->setRecipe( $this->getReference('fixRecipe1') )->createId();
        $em->persist($entity3);
        $this->addReference('fixCooking3', $entity3);




        $entity4 = new Cooking();
        $entity4->setPosition(1)->setDescription("1st step")->setRecipe( $this->getReference('fixRecipe2') )->createId();
        $em->persist($entity4);
        $this->addReference('fixCooking4', $entity4);

        $entity5 = new Cooking();
        $entity5->setPosition(2)->setDescription("2nd step")->setRecipe( $this->getReference('fixRecipe2') )->createId();
        $em->persist($entity5);
        $this->addReference('fixCooking5', $entity5);

        $entity6 = new Cooking();
        $entity6->setPosition(3)->setDescription("3th step")->setRecipe( $this->getReference('fixRecipe2') )->createId();
        $em->persist($entity6);
        $this->addReference('fixCooking6', $entity6);




        $entity7 = new Cooking();
        $entity7->setPosition(1)->setDescription("1st step")->setRecipe( $this->getReference('fixRecipe3') )->createId();
        $em->persist($entity7);
        $this->addReference('fixCooking7', $entity7);

        $entity8 = new Cooking();
        $entity8->setPosition(2)->setDescription("2nd step")->setRecipe( $this->getReference('fixRecipe3') )->createId();
        $em->persist($entity8);
        $this->addReference('fixCooking8', $entity8);

        $entity9 = new Cooking();
        $entity9->setPosition(3)->setDescription("3th step")->setRecipe( $this->getReference('fixRecipe3') )->createId();
        $em->persist($entity9);
        $this->addReference('fixCooking9', $entity9);

        $em->flush();
        self::$members = array($entity1, $entity2, $entity3, $entity4, $entity5, $entity6, $entity7, $entity8, $entity9);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 6;
    }
}
