<?php

namespace Barra\AdminBundle\Entity\Traits;

/**
 * Class IdAutoTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity\Traits
 */
trait IdAutoTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(
     *      name = "id",
     *      type = "integer"
     * )
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
