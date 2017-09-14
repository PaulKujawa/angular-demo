<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Measurement;
use AppBundle\Entity\Product;
use AppBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

class LoadIngredientData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var Ingredient[]
     */
    static public $members = [];

    public function load(ObjectManager $em): void
    {
        self::$members[] = $this->instantiate(1, 'refMeasurement1', 'refRecipe1', 'refProduct1');
        self::$members[] = $this->instantiate(2, 'refMeasurement1', 'refRecipe1', 'refProduct2');
        self::$members[] = $this->instantiate(3, 'refMeasurement1', 'refRecipe2', 'refProduct1');

        array_walk(self::$members, function(Ingredient $member, $i) use ($em) {
            $this->addReference('refIngredient' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    private function instantiate(int $amount, string $refMeasurement, string $refRecipe, string $refProduct): Ingredient
    {
        $measurement = $this->getReference($refMeasurement);
        $recipe = $this->getReference($refRecipe);
        $product = $this->getReference($refProduct);

        if (!$measurement instanceof Measurement ||
            !$recipe instanceof Recipe ||
            !$product instanceof Product
        ) {
            throw new InvalidArgumentException();
        }

        $ingredient = new Ingredient($recipe->getId());
        $ingredient->amount = $amount;
        $ingredient->measurement = $measurement;
        $ingredient->product = $product;

        return $ingredient;
    }

    public function getOrder(): int
    {
        return 8;
    }
}
