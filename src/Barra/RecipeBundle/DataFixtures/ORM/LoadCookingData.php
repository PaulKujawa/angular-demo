<?php

namespace Barra\RecipeBundle\DataFixtures\ORM;

use Barra\RecipeBundle\Entity\Cooking;
use Barra\RecipeBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

/**
 * Class LoadCookingData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\DataFixtures\ORM
 */
class LoadCookingData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate(1, '1th step', 'refRecipe1');
        self::$members[] = $this->instantiate(2, '2th step', 'refRecipe1');
        self::$members[] = $this->instantiate(3, '3th step', 'refRecipe1');

        foreach (self::$members as $i => $e) {
            $this->addReference('refCooking'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }

    /**
     * @param int       $position
     * @param string    $description
     * @param string    $refRecipe
     * @return Cooking
     */
    protected function instantiate($position, $description, $refRecipe)
    {
        $recipe = $this->getReference($refRecipe);

        if (!$recipe instanceof Recipe) {
            throw new InvalidArgumentException();
        }

        $entity = new Cooking();
        $entity
            ->setPosition($position)
            ->setDescription($description)
            ->setRecipe($recipe);

        return $entity;
    }

    public function getOrder()
    {
        return 6;
    }
}
