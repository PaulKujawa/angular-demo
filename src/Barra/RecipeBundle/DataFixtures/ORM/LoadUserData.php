<?php

namespace Barra\RecipeBundle\DataFixtures\ORM;

use Barra\RecipeBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('demoSA', 'test@gmx.de', 'testo', 'ROLE_SUPER_ADMIN');

        foreach (self::$members as $i => $e) {
            $this->addReference('refUser'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }

    /**
     * @param string    $name
     * @param string    $email
     * @param string    $plainPsw
     * @param string    $role
     * @return User
     */
    protected function instantiate($name, $email, $plainPsw, $role)
    {
        $entity = new User();
        $entity
            ->setUsername($name)
            ->setEmail($email)
            ->setPlainPassword($plainPsw)
            ->addRole($role)
            ->setEnabled(true);

        return $entity;
    }

    public function getOrder()
    {
        return 1;
    }
}