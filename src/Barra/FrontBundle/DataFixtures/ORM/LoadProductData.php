<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\Product;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new Product();
        $entity1->setName("fixProduct1")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer1') );
        $em->persist($entity1);
        $this->addReference('fixProduct1', $entity1);

        $entity2 = new Product();
        $entity2->setName("fixProduct2")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer1') );
        $em->persist($entity2);
        $this->addReference('fixProduct2', $entity2);

        $entity3 = new Product();
        $entity3->setName("fixProduct3")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer1') );
        $em->persist($entity3);
        $this->addReference('fixProduct3', $entity3);




        $entity4 = new Product();
        $entity4->setName("fixProduct4")->setVegan(false)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer2') );
        $em->persist($entity4);
        $this->addReference('fixProduct4', $entity4);

        $entity5 = new Product();
        $entity5->setName("fixProduct5")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer2') );
        $em->persist($entity5);
        $this->addReference('fixProduct5', $entity5);

        $entity6 = new Product();
        $entity6->setName("fixProduct6")->setVegan(false)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer2') );
        $em->persist($entity6);
        $this->addReference('fixProduct6', $entity6);




        $entity7 = new Product();
        $entity7->setName("fixProduct7")->setVegan(false)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer3') );
        $em->persist($entity7);
        $this->addReference('fixProduct7', $entity7);

        $entity8 = new Product();
        $entity8->setName("fixProduct8")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer3') );
        $em->persist($entity8);
        $this->addReference('fixProduct8', $entity8);

        $entity9 = new Product();
        $entity9->setName("fixProduct9")->setVegan(true)->setGr(1)->setKcal(1)->setCarbs(1)->setSugar(1)
            ->setProtein(1)->setFat(1)->setGfat(1)->setManufacturer( $this->getReference('fixManufacturer3') );
        $em->persist($entity9);
        $this->addReference('fixProduct9', $entity9);

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
