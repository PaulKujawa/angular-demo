<?php

namespace Barra\AdminBundle\Entity;

use Barra\AdminBundle\Entity\Traits\DescriptionTrait;
use Barra\AdminBundle\Entity\Traits\PositionTrait;
use Barra\AdminBundle\Entity\Traits\RecipeTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Cooking
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity
 *
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity({
 *      "recipe",
 *      "position"
 * })
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass = "Barra\AdminBundle\Entity\Repository\RecipeRelatedRepository")
 */
class Cooking
{
    use PositionTrait,
        RecipeTrait,
        DescriptionTrait
    ;

    /**
     * @var int
     *
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
     *
     * @return $this
     * @throws \RuntimeException
     */
    public function createId()
    {
        if (null === $this->getRecipe() ||
            null === $this->getRecipe()->getId() ||
            null === $this->getPosition()
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return bool
     */
    public function isRemovable()
    {
        return true;
    }
}
