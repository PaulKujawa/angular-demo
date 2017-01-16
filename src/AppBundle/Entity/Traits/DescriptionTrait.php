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
     *      type = "string",
     *      length = 120,
     * )
     */
    private $description;

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
