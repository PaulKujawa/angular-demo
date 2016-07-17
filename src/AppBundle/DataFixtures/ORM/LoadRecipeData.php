<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRecipeData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $em)
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

    /**
     * @param string $name
     *
     * @return Recipe
     */
    protected function instantiate($name)
    {
        $entity = new Recipe;
        $entity->setName($name);

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 4;
    }
}
