<?php

namespace AppBundle\Entity\Traits;

trait IdAutoTrait
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Column(type = "integer")
     */
    public $id;
}
