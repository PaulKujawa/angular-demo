<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Cooking;
use AppBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

class LoadCookingData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var Cooking[]
     */
    static public $members = [];

    public function load(ObjectManager $em): void
    {
        self::$members[] = $this->instantiate(1, '1th step', 'refRecipe1');
        self::$members[] = $this->instantiate(2, '2th step', 'refRecipe1');
        self::$members[] = $this->instantiate(3, '3th step', 'refRecipe1');

        array_walk(self::$members, function(Cooking $member, $i) use ($em) {
            $this->addReference('refCooking' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    private function instantiate(int $position, string $description, string $refRecipe): Cooking
    {
        $recipe = $this->getReference($refRecipe);

        if (!$recipe instanceof Recipe) {
            throw new InvalidArgumentException();
        }

        $cooking = new Cooking($recipe->getId(), $position);
        $cooking->description = $description;

        return $cooking;
    }

    public function getOrder(): int
    {
        return 6;
    }
}
