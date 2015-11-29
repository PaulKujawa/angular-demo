<?php

namespace Barra\RecipeBundle\DataFixtures\ORM;

use Barra\RecipeBundle\Entity\Ingredient;
use Barra\RecipeBundle\Entity\Measurement;
use Barra\RecipeBundle\Entity\Product;
use Barra\RecipeBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

/**
 * Class LoadIngredientData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\DataFixtures\ORM
 */
class LoadIngredientData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate(1, 1, 'refMeasurement1', 'refRecipe1', 'refProduct1');
        self::$members[] = $this->instantiate(2, 2, 'refMeasurement1', 'refRecipe1', 'refProduct2');
        self::$members[] = $this->instantiate(3, 3, 'refMeasurement1', 'refRecipe2', 'refProduct1');

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
     * @throws InvalidArgumentException
     */
    protected function instantiate($position, $amount, $refMeasurement, $refRecipe, $refProduct)
    {
        $measurement = $this->getReference($refMeasurement);
        $recipe      = $this->getReference($refRecipe);
        $product     = $this->getReference($refProduct);

        if (!$measurement instanceof Measurement ||
            !$recipe instanceof Recipe ||
            !$product instanceof Product
        ) {
            throw new InvalidArgumentException();
        }

        $entity = new Ingredient();
        $entity
            ->setPosition($position)
            ->setAmount($amount)
            ->setMeasurement($measurement)
            ->setRecipe($recipe)
            ->setProduct($product);

        return $entity;
    }

    public function getOrder()
    {
        return 8;
    }
}
