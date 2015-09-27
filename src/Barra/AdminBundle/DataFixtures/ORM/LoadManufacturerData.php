<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Barra\AdminBundle\Entity\Manufacturer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

/**
 * Class LoadManufacturerData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\DataFixtures\ORM
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
     * @throws InvalidArgumentException
     */
    protected function instantiate($name)
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException();
        }

        $entity = new Manufacturer();
        $entity->setName($name);

        return $entity;
    }

    public function getOrder()
    {
        return 1;
    }
}
