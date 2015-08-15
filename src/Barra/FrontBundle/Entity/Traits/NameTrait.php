<?php

namespace Barra\FrontBundle\Entity\Traits;

use Barra\FrontBundle\Entity\Recipe;

/**
 * Class NameTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity\Traits
 */
trait NameTrait
{
    /**
     * @ORM\Column(
     *      name   = "name",
     *      type   = "string",
     *      length = 40,
     *      unique = true
     * )
     */
    private $name;

    /**
     * @param string $name
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
