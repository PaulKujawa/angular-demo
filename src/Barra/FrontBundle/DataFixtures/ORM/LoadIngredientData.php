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
        $entity1->setName("fixIngredient1")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer1') );
        $em->persist($entity1);
        $this->addReference('fixIngredient1', $entity1);

        $entity2 = new Ingredient();
        $entity2->setName("fixIngredient2")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer1') );
        $em->persist($entity2);
        $this->addReference('fixIngredient2', $entity2);

        $entity3 = new Ingredient();
        $entity3->setName("fixIngredient3")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer1') );
        $em->persist($entity3);
        $this->addReference('fixIngredient3', $entity3);




        $entity4 = new Ingredient();
        $entity4->setName("fixIngredient4")->setVegan(false)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer2') );
        $em->persist($entity4);
        $this->addReference('fixIngredient4', $entity4);

        $entity5 = new Ingredient();
        $entity5->setName("fixIngredient5")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer2') );
        $em->persist($entity5);
        $this->addReference('fixIngredient5', $entity5);

        $entity6 = new Ingredient();
        $entity6->setName("fixIngredient6")->setVegan(false)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer2') );
        $em->persist($entity6);
        $this->addReference('fixIngredient6', $entity6);




        $entity7 = new Ingredient();
        $entity7->setName("fixIngredient7")->setVegan(false)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer3') );
        $em->persist($entity7);
        $this->addReference('fixIngredient7', $entity7);

        $entity8 = new Ingredient();
        $entity8->setName("fixIngredient8")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer3') );
        $em->persist($entity8);
        $this->addReference('fixIngredient8', $entity8);

        $entity9 = new Ingredient();
        $entity9->setName("fixIngredient9")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer3') );
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
        return 2;
    }
}
