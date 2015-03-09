<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\Recipe;

// later $recipePicture->setRecipe($this->getReference('recipe'));
class LoadRecipeData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $recipe1 = new Recipe();
        $recipe1->setName("fixtureRecipe1")->setRating(50)->setVotes(2);
        $em->persist($recipe1);
        $this->addReference('recipe1', $recipe1);

        $recipe2 = new Recipe();
        $recipe2->setName("fixtureRecipe2")->setRating(50)->setVotes(2);
        $em->persist($recipe2);
        $this->addReference('recipe2', $recipe2);

        $recipe3 = new Recipe();
        $recipe3->setName("fixtureRecipe3")->setRating(50)->setVotes(2);
        $em->persist($recipe3);
        $this->addReference('recipe3', $recipe3);

        $em->flush();
        self::$members = array($recipe1, $recipe2, $recipe3);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // starts with 1
    }
}
