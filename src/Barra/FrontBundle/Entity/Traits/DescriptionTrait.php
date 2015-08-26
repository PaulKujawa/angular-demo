<?php

namespace Barra\FrontBundle\Entity\Traits;

/**
 * Class DescriptionTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity\Traits
 */
trait DescriptionTrait
{
    /**
     * @var string
     * @ORM\Column(
     *      name        = "description",
     *      type        = "string",
     *      length      = 50,
     *      nullable    = false
     * )
     */
    private $description;

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
