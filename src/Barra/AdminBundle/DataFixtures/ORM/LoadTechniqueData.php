<?php

namespace Barra\AdminBundle\DataFixtures\ORM;

use Barra\AdminBundle\Entity\Technique;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadTechniqueData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\DataFixtures\ORM
 */
class LoadTechniqueData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];


    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('Technique1', 'description1', 'http://a.com');
        self::$members[] = $this->instantiate('Technique2', 'description2', 'http://b.com');
        self::$members[] = $this->instantiate('Technique3', 'description3', 'http://c.com');

        foreach (self::$members as $i => $e) {
            $this->addReference('refTechnique'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }


    /**
     * @param string    $name
     * @param string    $description
     * @param string    $url
     * @return Technique
     */
    protected function instantiate($name, $description, $url)
    {
        $entity = new Technique();
        $entity
            ->setName($name)
            ->setDescription($description)
            ->setUrl($url)
        ;

        return $entity;
    }


    public function getOrder()
    {
        return 9;
    }
}
