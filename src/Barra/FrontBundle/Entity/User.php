<?php

namespace Barra\FrontBundle\Entity;

use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 * @ORM\Table()
 * @ORM\Entity
 */
class User implements UserInterface
{
    // TODO not implemented & working yet! FOS implementation required !

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="string", length=255, unique=true, nullable=false)
     */
    private $username;


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setUsername($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->name;
    }
}
