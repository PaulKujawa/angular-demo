<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRecipeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var Recipe[]
     */
    static public $members = [];

    public function load(ObjectManager $em): void
    {
        self::$members[] = $this->instantiate('Recipe1');
        self::$members[] = $this->instantiate('Recipe2');
        self::$members[] = $this->instantiate('Recipe3');

        array_walk(self::$members, function(Recipe $member, $i) use ($em) {
            $this->addReference('refRecipe' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    protected function instantiate(string $name): Recipe
    {
        $entity = new Recipe;
        $entity->name = $name;

        return $entity;
    }

    public function getOrder(): int
    {
        return 4;
    }
}
