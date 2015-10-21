<?php

namespace Barra\AdminBundle\DataFixtures\ORM;

use Barra\AdminBundle\Entity\Measurement;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

/**
 * Class LoadMeasurementData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\DataFixtures\ORM
 */
class LoadMeasurementData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('gr', 1);
        self::$members[] = $this->instantiate('el', 15);
        self::$members[] = $this->instantiate('ml', 1);

        foreach (self::$members as $i => $e) {
            $this->addReference('refMeasurement'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }


    /**
     * @param string    $name
     * @param int       $gr
     * @return Measurement
     */
    protected function instantiate($name, $gr)
    {
        $entity = new Measurement();
        $entity
            ->setName($name)
            ->setGr($gr)
        ;

        return $entity;
    }


    public function getOrder()
    {
        return 3;
    }
}
