<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
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
        self::$members[] = $this->instantiate('demoSA', 'test@gmx.de', 'testo');

        array_walk(self::$members, function(User $member, $i) use ($em) {
            $this->addReference('refUser' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    /**
     * @param string $name
     * @param string $email
     * @param string $plainPsw
     *
     * @return User
     */
    protected function instantiate($name, $email, $plainPsw)
    {
        $user = new User();
        $user
            ->setUsername($name)
            ->setEmail($email)
            ->setPlainPassword($plainPsw)
            ->setEnabled(true);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
