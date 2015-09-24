<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Barra\BackBundle\Entity\Manufacturer;
use Barra\BackBundle\Entity\Product;
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
        $nutritions = [
            'gr'        => 1,
            'kcal'      => 1,
            'carbs'     => 1.0,
            'sugar'     => 1.0,
            'protein'   => 1.0,
            'fat'       => 1.0,
            'gfat'      => 1.0,
        ];
        
        self::$members[] = $this->instantiate('Product1', false, $nutritions, 'refManufacturer1');
        self::$members[] = $this->instantiate('Product2', true, $nutritions, 'refManufacturer1');
        self::$members[] = $this->instantiate('Product3', true, $nutritions, 'refManufacturer1');

        self::$members[] = $this->instantiate('Product4', true, $nutritions, 'refManufacturer2');
        self::$members[] = $this->instantiate('Product5', false, $nutritions, 'refManufacturer2');
        self::$members[] = $this->instantiate('Product6', true, $nutritions, 'refManufacturer2');

        self::$members[] = $this->instantiate('Product7', false, $nutritions, 'refManufacturer3');
        self::$members[] = $this->instantiate('Product8', true, $nutritions, 'refManufacturer3');
        self::$members[] = $this->instantiate('Product9', true, $nutritions, 'refManufacturer3');

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