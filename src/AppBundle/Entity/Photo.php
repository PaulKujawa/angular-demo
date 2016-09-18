<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity("filename")
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass = "AppBundle\Entity\Repository\RecipeRelatedRepository")
 */
class Photo
{
    use IdAutoTrait;
    use ImageTrait;

    /**
     * @param int $recipeId
     */
    public function __construct($recipeId)
    {
        $this->recipe = $recipeId;
    }

    /**
     * @var Recipe
     *
     * @Assert\NotNull()
     *
     * @Serializer\Exclude()
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Recipe",
     *      inversedBy = "photos"
     * )
     * @ORM\JoinColumn(
     *      name = "recipe",
     *      referencedColumnName = "id",
     *      nullable = false,
     *      onDelete = "CASCADE"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $recipe;

    /**
     * @param Recipe $recipe
     */
    public function setRecipe(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }
}
