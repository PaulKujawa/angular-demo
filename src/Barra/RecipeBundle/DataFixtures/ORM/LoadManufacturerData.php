<?php

namespace Barra\RecipeBundle\DataFixtures\ORM;

use Barra\RecipeBundle\Entity\Manufacturer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadManufacturerData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('Manufacturer1');
        self::$members[] = $this->instantiate('Manufacturer2');
        self::$members[] = $this->instantiate('Manufacturer3');

        array_walk(self::$members, function($member, $i) use ($em) {
            $this->addReference('refManufacturer' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    /**
     * @param string $name
     *
     * @return Manufacturer
     */
    protected function instantiate($name)
    {
        $entity = new Manufacturer();
        $entity->setName($name);

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
