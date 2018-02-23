<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Measurement
{
    use IdAutoTrait;
    use TimestampTrait;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Length(min = 3, max = 40)
     *
     * @ORM\Column(
     *      type = "string",
     *      length = 40,
     *      unique = true,
     *      options = {"collation": "utf8_bin"}
     * )
     */
    public $name;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\GreaterThan(value = 0)
     *
     * @ORM\Column(type = "smallint")
     */
    public $gr;
}
