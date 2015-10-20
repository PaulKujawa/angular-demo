<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Barra\AdminBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadRecipeData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\DataFixtures\ORM
 */
class LoadRecipeData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('Recipe1');
        self::$members[] = $this->instantiate('Recipe2');
        self::$members[] = $this->instantiate('Recipe3');

        foreach (self::$members as $i => $e) {
            $this->addReference('refRecipe'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }


    /**
     * @param string $name
     * @return Recipe
     */
    protected function instantiate($name)
    {
        $entity = new Recipe;
        $entity->setName($name);

        return $entity;
    }


    public function getOrder()
    {
        return 4;
    }
}
