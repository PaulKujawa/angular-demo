<?php

namespace Barra\FrontBundle\Entity;

use Barra\FrontBundle\Entity\Traits\DescriptionTrait;
use Barra\FrontBundle\Entity\Traits\PositionTrait;
use Barra\FrontBundle\Entity\Traits\RecipeTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Cooking
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity
 *
 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\FrontBundle\Entity\Repository\CookingRepository")
 */
class Cooking
{
    use PositionTrait,
        RecipeTrait,
        DescriptionTrait
    ;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(
     *      name = "id",
     *      type = "integer"
     * )
     */
    protected $id;

    /**
     * @return $this
     */
    public function createId()
    {
        $this->id = $this->getRecipe()->getId() . $this->getPosition();

        return $this;
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
