<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var Product[]
     */
    static public $members = [];

    public function load(ObjectManager $em): void
    {
        self::$members[] = $this->instantiate('Product1', false);
        self::$members[] = $this->instantiate('Product2');
        self::$members[] = $this->instantiate('Product3');
        self::$members[] = $this->instantiate('Product4');

        array_walk(self::$members, function(Product $member, $i) use ($em) {
            $this->addReference('refProduct' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    private function instantiate(string $name, bool $isVegan = true): Product
    {
        $macros = [
            'gr' => 1,
            'kcal' => 1,
            'carbs' => 1.0,
            'sugar' => 1.0,
            'protein' => 1.0,
            'fat' => 1.0,
            'gfat' => 1.0,
        ];

        $entity = new Product();
        $entity->protein = $name;
        $entity->vegan = $isVegan;
        $entity->gr = $macros['gr'];
        $entity->kcal = $macros['kcal'];
        $entity->carbs = $macros['carbs'];
        $entity->sugar = $macros['sugar'];
        $entity->protein = $macros['protein'];
        $entity->fat = $macros['fat'];
        $entity->gfat = $macros['gfat'];

        return $entity;
    }

    public function getOrder(): int
    {
        return 5;
    }
}
