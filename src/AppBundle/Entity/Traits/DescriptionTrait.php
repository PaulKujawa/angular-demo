<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait DescriptionTrait
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 5, max = 120)
     *
     * @ORM\Column(type = "string", length = 120)
     */
    public $description;
}
