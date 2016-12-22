<?php

namespace AppBundle\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

trait NameTrait
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 3, max = 40)
     *
     * @ORM\Column(
     *      type = "string",
     *      length = 40,
     *      unique = true
     * )
     */
    private $name;

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
