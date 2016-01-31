<?php

namespace Barra\RecipeBundle\Entity\Traits;

trait IdAutoTrait
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Column(
     *      name = "id",
     *      type = "integer"
     * )
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
