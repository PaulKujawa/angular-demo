<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\RecipeIngredient;

class LoadRecipeIngredientData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new RecipeIngredient();
        $entity1->setRecipe($this->getReference('fixRecipe1'))->setIngredient($this->getReference('fixIngredient1'))
            ->setMeasurement($this->getReference('fixMeasurement1'))->setAmount(1)->setPosition(1);
        $em->persist($entity1);
        $this->addReference('fixRecipeIngredient1', $entity1);

        $entity2 = new RecipeIngredient();
        $entity2->setRecipe($this->getReference('fixRecipe1'))->setIngredient($this->getReference('fixIngredient2'))
            ->setMeasurement($this->getReference('fixMeasurement2'))->setAmount(1)->setPosition(2);
        $em->persist($entity2);
        $this->addReference('fixRecipeIngredient2', $entity2);

        $entity3 = new RecipeIngredient();
        $entity3->setRecipe($this->getReference('fixRecipe1'))->setIngredient($this->getReference('fixIngredient3'))
            ->setMeasurement($this->getReference('fixMeasurement3'))->setAmount(1)->setPosition(3);
        $em->persist($entity3);
        $this->addReference('fixRecipeIngredient3', $entity3);




        $entity4 = new RecipeIngredient();
        $entity4->setRecipe($this->getReference('fixRecipe2'))->setIngredient($this->getReference('fixIngredient1'))
            ->setMeasurement($this->getReference('fixMeasurement1'))->setAmount(1)->setPosition(1);
        $em->persist($entity4);
        $this->addReference('fixRecipeIngredient4', $entity4);

        $entity5 = new RecipeIngredient();
        $entity5->setRecipe($this->getReference('fixRecipe2'))->setIngredient($this->getReference('fixIngredient2'))
            ->setMeasurement($this->getReference('fixMeasurement2'))->setAmount(1)->setPosition(2);
        $em->persist($entity5);
        $this->addReference('fixRecipeIngredient5', $entity5);

        $entity6 = new RecipeIngredient();
        $entity6->setRecipe($this->getReference('fixRecipe2'))->setIngredient($this->getReference('fixIngredient3'))
            ->setMeasurement($this->getReference('fixMeasurement3'))->setAmount(1)->setPosition(3);
        $em->persist($entity6);
        $this->addReference('fixRecipeIngredient6', $entity6);




        $entity7 = new RecipeIngredient();
        $entity7->setRecipe($this->getReference('fixRecipe3'))->setIngredient($this->getReference('fixIngredient1'))
            ->setMeasurement($this->getReference('fixMeasurement1'))->setAmount(1)->setPosition(1);
        $em->persist($entity7);
        $this->addReference('fixRecipeIngredient7', $entity7);

        $entity8 = new RecipeIngredient();
        $entity8->setRecipe($this->getReference('fixRecipe3'))->setIngredient($this->getReference('fixIngredient2'))
            ->setMeasurement($this->getReference('fixMeasurement2'))->setAmount(1)->setPosition(2);
        $em->persist($entity8);
        $this->addReference('fixRecipeIngredient8', $entity8);

        $entity9 = new RecipeIngredient();
        $entity9->setRecipe($this->getReference('fixRecipe3'))->setIngredient($this->getReference('fixIngredient3'))
            ->setMeasurement($this->getReference('fixMeasurement3'))->setAmount(1)->setPosition(3);
        $em->persist($entity9);
        $this->addReference('fixRecipeIngredient9', $entity9);

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
