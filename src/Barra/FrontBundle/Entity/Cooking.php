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
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @return $this
     * @throws \RuntimeException
     */
    public function createId()
    {
        if (is_null($this->getRecipe()) ||
            is_null($this->getRecipe()->getId()) ||
            is_null($this->getPosition())
        ) {
            throw new \RuntimeException(sprintf(
                '"%s" and "%s" must have been set',
                'recipe',
                'position'
            ));
        }
        $this->id = $this->getRecipe()->getId() . $this->getPosition();

        return $this;
    }

    /**
     * Get id
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
