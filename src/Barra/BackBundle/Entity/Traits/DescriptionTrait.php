<?php

namespace Barra\BackBundle\Entity\Traits;

/**
 * Class DescriptionTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Entity\Traits
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
     * @param string $description
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setDescription($description)
    {
        if (!is_string($description)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'description',
                'string'
            ));
        }
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
