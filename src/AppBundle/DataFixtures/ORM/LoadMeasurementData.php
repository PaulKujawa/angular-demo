<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Measurement;
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

        array_walk(self::$members, function(Measurement $member, $i) use ($em) {
            $this->addReference('refMeasurement' . ($i + 1), $member);
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
    private function instantiate($name, $gr)
    {
        $measurement = new Measurement();
        $measurement->setName($name);
        $measurement->setGr($gr);

        return $measurement;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 3;
    }
}
