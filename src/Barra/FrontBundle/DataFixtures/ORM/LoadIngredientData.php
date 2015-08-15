<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\Ingredient;

class LoadIngredientData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new Ingredient();
        $entity1->setRecipe($this->getReference('fixRecipe1'))->setProduct($this->getReference('fixProduct1'))
            ->setMeasurement($this->getReference('fixMeasurement1'))->setAmount(1)->setPosition(1)->createId();
        $em->persist($entity1);
        $this->addReference('fixIngredient1', $entity1);

        $entity2 = new Ingredient();
        $entity2->setRecipe($this->getReference('fixRecipe1'))->setProduct($this->getReference('fixProduct2'))
            ->setMeasurement($this->getReference('fixMeasurement2'))->setAmount(1)->setPosition(2)->createId();
        $em->persist($entity2);
        $this->addReference('fixIngredient2', $entity2);

        $entity3 = new Ingredient();
        $entity3->setRecipe($this->getReference('fixRecipe1'))->setProduct($this->getReference('fixProduct3'))
            ->setMeasurement($this->getReference('fixMeasurement3'))->setAmount(1)->setPosition(3)->createId();
        $em->persist($entity3);
        $this->addReference('fixIngredient3', $entity3);




        $entity4 = new Ingredient();
        $entity4->setRecipe($this->getReference('fixRecipe2'))->setProduct($this->getReference('fixProduct1'))
            ->setMeasurement($this->getReference('fixMeasurement1'))->setAmount(1)->setPosition(1)->createId();
        $em->persist($entity4);
        $this->addReference('fixIngredient4', $entity4);

        $entity5 = new Ingredient();
        $entity5->setRecipe($this->getReference('fixRecipe2'))->setProduct($this->getReference('fixProduct2'))
            ->setMeasurement($this->getReference('fixMeasurement2'))->setAmount(1)->setPosition(2)->createId();
        $em->persist($entity5);
        $this->addReference('fixIngredient5', $entity5);

        $entity6 = new Ingredient();
        $entity6->setRecipe($this->getReference('fixRecipe2'))->setProduct($this->getReference('fixProduct3'))
            ->setMeasurement($this->getReference('fixMeasurement3'))->setAmount(1)->setPosition(3)->createId();
        $em->persist($entity6);
        $this->addReference('fixIngredient6', $entity6);




        $entity7 = new Ingredient();
        $entity7->setRecipe($this->getReference('fixRecipe3'))->setProduct($this->getReference('fixProduct1'))
            ->setMeasurement($this->getReference('fixMeasurement1'))->setAmount(1)->setPosition(1)->createId();
        $em->persist($entity7);
        $this->addReference('fixIngredient7', $entity7);

        $entity8 = new Ingredient();
        $entity8->setRecipe($this->getReference('fixRecipe3'))->setProduct($this->getReference('fixProduct2'))
            ->setMeasurement($this->getReference('fixMeasurement2'))->setAmount(1)->setPosition(2)->createId();
        $em->persist($entity8);
        $this->addReference('fixIngredient8', $entity8);

        $entity9 = new Ingredient();
        $entity9->setRecipe($this->getReference('fixRecipe3'))->setProduct($this->getReference('fixProduct3'))
            ->setMeasurement($this->getReference('fixMeasurement3'))->setAmount(1)->setPosition(3)->createId();
        $em->persist($entity9);
        $this->addReference('fixIngredient9', $entity9);

        $em->flush();
        self::$members = array($entity1, $entity2, $entity3, $entity4, $entity5, $entity6, $entity7, $entity8, $entity9);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 5;
    }
}
