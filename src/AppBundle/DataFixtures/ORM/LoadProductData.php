<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Manufacturer;
use AppBundle\Entity\Product;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

class LoadProductData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('Product1', 'Rinatura', false);
        self::$members[] = $this->instantiate('Product2', 'Soja so lecker');
        self::$members[] = $this->instantiate('Product3', 'Vitam');
        self::$members[] = $this->instantiate('Product4');

        array_walk(self::$members, function(Product $member, $i) use ($em) {
            $this->addReference('refProduct' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    /**
     * @param string $name
     * @param string $manufacturer
     * @param bool $isVegan
     *
     * @return Product
     */
    private function instantiate($name, $manufacturer = null, $isVegan = true)
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
        $entity->setName($name);
        $entity->setVegan($isVegan);
        $entity->setGr($macros['gr']);
        $entity->setKcal($macros['kcal']);
        $entity->setCarbs($macros['carbs']);
        $entity->setSugar($macros['sugar']);
        $entity->setProtein($macros['protein']);
        $entity->setFat($macros['fat']);
        $entity->setGfat($macros['gfat']);
        $entity->setManufacturer($manufacturer);

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 5;
    }
}
