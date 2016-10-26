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
     *      name = "name",
     *      type = "string",
     *      length = 40,
     *      unique = true
     * )
     */
    private $name;

    /**
     * @param string $name
     *
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
