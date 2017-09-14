<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Measurement;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMeasurementData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var Measurement[]
     */
    static public $members = [];

    public function load(ObjectManager $em): void
    {
        self::$members[] = $this->instantiate('gr', 1);
        self::$members[] = $this->instantiate('el', 15);
        self::$members[] = $this->instantiate('ml', 1);

        array_walk(self::$members, function(Measurement $member, $i) use ($em) {
            $this->addReference('refMeasurement' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    private function instantiate(string $name, int $gr): Measurement
    {
        $measurement = new Measurement();
        $measurement->name = $name;
        $measurement->gr = $gr;

        return $measurement;
    }

    public function getOrder(): int
    {
        return 3;
    }
}
