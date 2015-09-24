<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Barra\BackBundle\Entity\Agency;
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
        self::$members[] = $this->instantiate('Agency1', 'a.com');
        self::$members[] = $this->instantiate('Agency2', 'b.com');
        self::$members[] = $this->instantiate('Agency3', 'c.com');

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
        if (!is_string($name) ||
            !is_string($url)
        ) {
            throw new InvalidArgumentException();
        }

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
