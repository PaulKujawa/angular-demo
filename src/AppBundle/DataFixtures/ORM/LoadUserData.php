<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var User[]
     */
    static public $members = [];

    public function load(ObjectManager $em): void
    {
        self::$members[] = $this->instantiate('demoSA', 'test@gmx.de', 'testo');

        array_walk(self::$members, function(User $member, $i) use ($em) {
            $this->addReference('refUser' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    protected function instantiate(string $name, string $email, string $plainPsw): User
    {
        $user = new User();
        $user
            ->setUsername($name)
            ->setEmail($email)
            ->setPlainPassword($plainPsw)
            ->setEnabled(true);

        return $user;
    }

    public function getOrder(): int
    {
        return 1;
    }
}
