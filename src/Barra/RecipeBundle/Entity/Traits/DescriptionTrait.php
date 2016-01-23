<?php

namespace Barra\RecipeBundle\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class DescriptionTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Entity\Traits
 */
trait DescriptionTrait
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 50
     * )
     *
     * @ORM\Column(
     *      name    = "description",
     *      type    = "string",
     *      length  = 50,
     * )
     */
    private $description;

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
