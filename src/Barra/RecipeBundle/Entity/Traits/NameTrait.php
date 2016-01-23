<?php

namespace Barra\RecipeBundle\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class NameTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Entity\Traits
 */
trait NameTrait
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 1,
     *      max = 40
     * )
     *
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
     * @return $this
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
