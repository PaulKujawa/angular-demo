<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Product
{
    use IdAutoTrait;
    use NameTrait;
    use TimestampTrait;

    /**
     * @var bool
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(type = "boolean")
     */
    public $vegan;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0)
     *
     * @ORM\Column(type = "smallint")
     */
    public $gr;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0)
     *
     * @ORM\Column(type = "integer")
     */
    public $kcal;

    /**
     * @var float
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      type = "decimal",
     *      scale = 1
     * )
     */
    public $protein;

    /**
     * @var float
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      type = "decimal",
     *      scale = 1
     * )
     */
    public $carbs;

    /**
     * @var float
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      type = "decimal",
     *      scale = 1
     * )
     */
    public $sugar;

    /**
     * @var float
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      type = "decimal",
     *      scale = 1
     * )
     */
    public $fat;

    /**
     * @var float
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      type = "decimal",
     *      scale = 1
     * )
     */
    public $gfat;

    /**
     * @var string
     *
     * @Assert\Length(max = 40)
     *
     * @ORM\Column(
     *     type = "string",
     *     length = 40,
     *     nullable = true
     * )
     */
    public $manufacturer;
}
