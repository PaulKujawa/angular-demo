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
        self::$members[] = $this->instantiate('Product1', false, [1, 1, 1.0, 1.0, 1.0, 1.0, 1.0], 'refManufacturer1');
        self::$members[] = $this->instantiate('Product2', true, [1, 1, 1.0, 1.0, 1.0, 1.0, 1.0], 'refManufacturer1');
        self::$members[] = $this->instantiate('Product3', true, [1, 1, 1.0, 1.0, 1.0, 1.0, 1.0], 'refManufacturer1');

        self::$members[] = $this->instantiate('Product4', true, [1, 1, 1.0, 1.0, 1.0, 1.0, 1.0], 'refManufacturer2');
        self::$members[] = $this->instantiate('Product5', false, [1, 1, 1.0, 1.0, 1.0, 1.0, 1.0], 'refManufacturer2');
        self::$members[] = $this->instantiate('Product6', true, [1, 1, 1.0, 1.0, 1.0, 1.0, 1.0], 'refManufacturer2');

        self::$members[] = $this->instantiate('Product7', false, [1, 1, 1.0, 1.0, 1.0, 1.0, 1.0], 'refManufacturer3');
        self::$members[] = $this->instantiate('Product8', true, [1, 1, 1.0, 1.0, 1.0, 1.0, 1.0], 'refManufacturer3');
        self::$members[] = $this->instantiate('Product9', true, [1, 1, 1.0, 1.0, 1.0, 1.0, 1.0], 'refManufacturer3');

        foreach (self::$members as $i => $e) {
            $this->addReference('refProduct'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }

    /**
     * @param string $name
     * @param bool $isVegan
     * @param array $nutritions
     * @param string $refManufacturer
     * @return Product
     */
    protected function instantiate($name, $isVegan, array $nutritions, $refManufacturer)
    {
        $manufacturer = $this->getReference($refManufacturer);

        if (!$manufacturer instanceof Manufacturer ||
            !is_string($name) ||
            !is_bool($isVegan) ||
            !is_int($nutritions['gr']) ||
            !is_int($nutritions['kcal']) ||
            !is_double($nutritions['carbs']) ||
            !is_double($nutritions['sugar']) ||
            !is_double($nutritions['protein']) ||
            !is_double($nutritions['fat']) ||
            !is_double($nutritions['gfat'])
        ) {
            throw new InvalidArgumentException(
                'array nutritions has to include gr, kcal, carbs, sugar, protein, fat and gfat.'
            );
        }

        $entity = new Product();
        $entity
            ->setName($name)
            ->setVegan($isVegan)
            ->setGr($nutritions['gr'])
            ->setKcal($nutritions['kcal'])
            ->setCarbs($nutritions['carbs'])
            ->setSugar($nutritions['sugar'])
            ->setProtein($nutritions['protein'])
            ->setFat($nutritions['fat'])
            ->setGfat($nutritions['gfat'])
            ->setManufacturer($manufacturer)
        ;

        return $entity;
    }

    public function getOrder()
    {
        return 2;
    }
}
