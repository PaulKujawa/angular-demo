<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Barra\AdminBundle\Entity\Agency;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

/**
 * Class LoadAgencyData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\DataFixtures\ORM
 */
class LoadAgencyData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('Agency1', 'http://a.com');
        self::$members[] = $this->instantiate('Agency2', 'http://b.com');
        self::$members[] = $this->instantiate('Agency3', 'http://c.com');

        foreach (self::$members as $i => $e) {
            $this->addReference('refAgency'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }


    /**
     * @param string    $name
     * @param string    $url
     * @return Agency
     * @throws InvalidArgumentException
     */
    protected function instantiate($name, $url)
    {
        $entity = new Agency();
        $entity
            ->setName($name)
            ->setUrl($url)
        ;

        return $entity;
    }


    public function getOrder()
    {
        return 8;
    }
}
