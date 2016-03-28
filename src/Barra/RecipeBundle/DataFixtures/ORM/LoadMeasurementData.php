<?php

namespace Barra\RecipeBundle\DataFixtures\ORM;

use Barra\RecipeBundle\Entity\Measurement;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMeasurementData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('gr', 1);
        self::$members[] = $this->instantiate('el', 15);
        self::$members[] = $this->instantiate('ml', 1);

        array_walk(self::$members, function($member, $i) use ($em) {
            $this->addReference('refMEasurement' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    /**
     * @param string $name
     * @param int $gr
     *
     * @return Measurement
     */
    protected function instantiate($name, $gr)
    {
        $entity = new Measurement();
        $entity
            ->setName($name)
            ->setGr($gr);

        return $entity;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
