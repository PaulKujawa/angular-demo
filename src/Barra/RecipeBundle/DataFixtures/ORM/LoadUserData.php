<?php

namespace Barra\RecipeBundle\DataFixtures\ORM;

use Barra\RecipeBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('demoSA', 'test@gmx.de', 'testo', 'ROLE_SUPER_ADMIN');

        array_walk(self::$members, function($member, $i) use ($em) {
            $this->addReference('refUser' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $plainPsw
     * @param string $role
     *
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

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
