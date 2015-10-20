<?php

namespace Barra\AdminBundle\Entity;

use Barra\AdminBundle\Entity\Traits\IdAutoTrait;
use Barra\AdminBundle\Entity\Traits\NameTrait;
use Barra\AdminBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Photo
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity
 *
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity("name")
 * @UniqueEntity("filename")
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass = "Barra\AdminBundle\Entity\Repository\RecipeRelatedRepository")
 */
class Photo
{
    use IdAutoTrait,
        NameTrait,
        ImageTrait
    ;

    /**
     * @var Recipe
     *
     * @Assert\NotNull()
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Recipe",
     *      inversedBy   = "photos"
     * )
     * @ORM\JoinColumn(
     *      name                 = "recipe",
     *      referencedColumnName = "id",
     *      nullable             = false,
     *      onDelete             = "CASCADE"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $recipe;

    /**
     * @param Recipe $recipe
     * @return $this
     */
    public function setRecipe(Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * @return bool
     */
    public function isRemovable()
    {
        return true;
    }
}
