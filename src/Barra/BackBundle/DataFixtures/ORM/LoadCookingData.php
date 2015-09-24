<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Barra\BackBundle\Entity\Cooking;
use Barra\BackBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

/**
 * Class LoadCookingData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\DataFixtures\ORM
 */
class LoadCookingData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate(1, '1th step', 'refRecipe1');
        self::$members[] = $this->instantiate(2, '2th step', 'refRecipe1');
        self::$members[] = $this->instantiate(3, '3th step', 'refRecipe1');

        self::$members[] = $this->instantiate(4, '1th step', 'refRecipe2');
        self::$members[] = $this->instantiate(5, '2th step', 'refRecipe2');
        self::$members[] = $this->instantiate(6, '3th step', 'refRecipe2');

        self::$members[] = $this->instantiate(7, '1th step', 'refRecipe3');
        self::$members[] = $this->instantiate(8, '2th step', 'refRecipe3');
        self::$members[] = $this->instantiate(9, '3th step', 'refRecipe3');

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
     * @throws InvalidArgumentException
     */
    protected function instantiate($position, $description, $refRecipe)
    {
        $recipe = $this->getReference($refRecipe);

        if (!$recipe instanceof Recipe ||
            !is_int($position) ||
            !is_string($description)
        ) {
            throw new InvalidArgumentException();
        }

        $entity = new Cooking();
        $entity
            ->setPosition($position)
            ->setDescription($description)
            ->setRecipe($recipe)
        ;

        return $entity;
    }

    public function getOrder()
    {
        return 6;
    }
}
