<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Barra\FrontBundle\Entity\Manufacturer;
use Barra\FrontBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

/**
 * Class LoadProductData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\DataFixtures\ORM
 */
class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('Product1', false, 1, 1, 1.0, 1.0, 1.0, 1.0, 1.0, 'refManufacturer1');
        self::$members[] = $this->instantiate('Product2', true,  1, 1, 1.0, 1.0, 1.0, 1.0, 1.0, 'refManufacturer1');
        self::$members[] = $this->instantiate('Product3', true,  1, 1, 1.0, 1.0, 1.0, 1.0, 1.0, 'refManufacturer1');

        self::$members[] = $this->instantiate('Product4', true,  1, 1, 1.0, 1.0, 1.0, 1.0, 1.0, 'refManufacturer2');
        self::$members[] = $this->instantiate('Product5', false, 1, 1, 1.0, 1.0, 1.0, 1.0, 1.0, 'refManufacturer2');
        self::$members[] = $this->instantiate('Product6', true,  1, 1, 1.0, 1.0, 1.0, 1.0, 1.0, 'refManufacturer2');

        self::$members[] = $this->instantiate('Product7', false, 1, 1, 1.0, 1.0, 1.0, 1.0, 1.0, 'refManufacturer3');
        self::$members[] = $this->instantiate('Product8', true,  1, 1, 1.0, 1.0, 1.0, 1.0, 1.0, 'refManufacturer3');
        self::$members[] = $this->instantiate('Product9', true,  1, 1, 1.0, 1.0, 1.0, 1.0, 1.0, 'refManufacturer3');

        foreach (self::$members as $i => $e) {
            $this->addReference('refProduct'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }

    /**
     * @param string    $name
     * @param bool      $isVegan
     * @param int       $gr
     * @param int       $kcal
     * @param double    $carbs
     * @param double    $sugar
     * @param double    $protein
     * @param double    $fat
     * @param double    $gfat
     * @param string    $refManufacturer
     * @return Product
     */
    protected function instantiate($name, $isVegan, $gr, $kcal, $carbs, $sugar, $protein, $fat, $gfat, $refManufacturer)
    {
        $manufacturer = $this->getReference($refManufacturer);

        if (!$manufacturer instanceof Manufacturer ||
            !is_string($name) ||
            !is_bool($isVegan) ||
            !is_int($gr) ||
            !is_int($kcal) ||
            !is_double($carbs) ||
            !is_double($sugar) ||
            !is_double($protein) ||
            !is_double($fat) ||
            !is_double($gfat)
        ) {
            throw new InvalidArgumentException();
        }

        $entity = new Product();
        $entity
            ->setName($name)
            ->setVegan($isVegan)
            ->setGr($gr)
            ->setKcal($kcal)
            ->setCarbs($carbs)
            ->setSugar($sugar)
            ->setProtein($protein)
            ->setFat($fat)
            ->setGfat($gfat)
            ->setManufacturer($manufacturer)
        ;

        return $entity;
    }

    public function getOrder()
    {
        return 2;
    }
}
