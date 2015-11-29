<?php

namespace Barra\RecipeBundle\Entity\Traits;

/**
 * Class IdAutoTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Entity\Traits
 */
trait IdAutoTrait
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(
     *      name = "id",
     *      type = "integer"
     * )
     * @ORM\GeneratedValue(strategy = "AUTO")
     */
    private $id;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
