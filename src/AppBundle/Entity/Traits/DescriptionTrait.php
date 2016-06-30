<?php

namespace AppBundle\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait DescriptionTrait
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 5,
     *      max = 120
     * )
     *
     * @ORM\Column(
     *      name    = "description",
     *      type    = "string",
     *      length  = 120,
     * )
     */
    private $description;

    /**
     * @param string $description
     *
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
