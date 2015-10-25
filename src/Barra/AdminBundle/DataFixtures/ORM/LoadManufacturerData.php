<?php

namespace Barra\AdminBundle\DataFixtures\ORM;

use Barra\AdminBundle\Entity\Manufacturer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadManufacturerData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\DataFixtures\ORM
 */
class LoadManufacturerData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];


    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('Manufacturer1');
        self::$members[] = $this->instantiate('Manufacturer2');
        self::$members[] = $this->instantiate('Manufacturer3');

        foreach (self::$members as $i => $e) {
            $this->addReference('refManufacturer'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }


    /**
     * @param string $name
     * @return Manufacturer
     */
    protected function instantiate($name)
    {
        $entity = new Manufacturer();
        $entity->setName($name);

        return $entity;
    }


    public function getOrder()
    {
        return 1;
    }
}
