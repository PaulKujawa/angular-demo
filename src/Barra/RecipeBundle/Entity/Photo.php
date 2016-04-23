<?php

namespace Barra\RecipeBundle\Entity;

use Barra\RecipeBundle\Entity\Traits\IdAutoTrait;
use Barra\RecipeBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity("filename")
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass = "Barra\RecipeBundle\Entity\Repository\RecipeRelatedRepository")
 */
class Photo
{
    use IdAutoTrait;
    use ImageTrait;

    /**
     * @var Recipe
     *
     * @Exclude
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
     *
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
