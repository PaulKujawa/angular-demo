<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Barra\AdminBundle\Entity\Ingredient;
use Barra\AdminBundle\Entity\Measurement;
use Barra\AdminBundle\Entity\Product;
use Barra\AdminBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

/**
 * Class LoadIngredientData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\DataFixtures\ORM
 */
class LoadIngredientData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate(1, 1, 'refMeasurement1', 'refRecipe1', 'refProduct1');
        self::$members[] = $this->instantiate(2, 2, 'refMeasurement2', 'refRecipe1', 'refProduct2');
        self::$members[] = $this->instantiate(3, 3, 'refMeasurement3', 'refRecipe1', 'refProduct3');

        self::$members[] = $this->instantiate(1, 4, 'refMeasurement1', 'refRecipe2', 'refProduct1');
        self::$members[] = $this->instantiate(2, 5, 'refMeasurement2', 'refRecipe2', 'refProduct2');
        self::$members[] = $this->instantiate(3, 6, 'refMeasurement3', 'refRecipe2', 'refProduct3');

        self::$members[] = $this->instantiate(1, 7, 'refMeasurement1', 'refRecipe3', 'refProduct1');
        self::$members[] = $this->instantiate(2, 8, 'refMeasurement2', 'refRecipe3', 'refProduct2');
        self::$members[] = $this->instantiate(3, 9, 'refMeasurement3', 'refRecipe3', 'refProduct3');

        foreach (self::$members as $i => $e) {
            $this->addReference('refIngredient'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }


    /**
     * @param int       $position
     * @param int       $amount
     * @param string    $refMeasurement
     * @param string    $refRecipe
     * @param string    $refProduct
     * @return Ingredient
     */
    protected function instantiate($position, $amount, $refMeasurement, $refRecipe, $refProduct)
    {
        $measurement = $this->getReference($refMeasurement);
        $recipe      = $this->getReference($refRecipe);
        $product     = $this->getReference($refProduct);

        if (!$measurement instanceof Measurement ||
            !$recipe instanceof Recipe ||
            !$product instanceof Product ||
            !is_int($position) ||
            !is_int($amount)
        ) {
            throw new InvalidArgumentException();
        }

        $entity = new Ingredient();
        $entity
            ->setPosition($position)
            ->setAmount($amount)
            ->setMeasurement($measurement)
            ->setRecipe($recipe)
            ->setProduct($product)
        ;

        return $entity;
    }

    public function getOrder()
    {
        return 5;
    }
}
