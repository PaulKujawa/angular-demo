<?php

namespace Barra\FrontBundle\Entity\Traits;

use Barra\FrontBundle\Entity\Recipe;

/**
 * Class RecipeTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity\Traits
 */
trait RecipeTrait
{
    /**
     * @var Recipe
     * @ORM\ManyToOne(
     *      targetEntity = "Recipe"
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
     * Set recipe
     *
     * @param Recipe $recipe
     * @return $this
     */
    public function setRecipe(Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }
}
