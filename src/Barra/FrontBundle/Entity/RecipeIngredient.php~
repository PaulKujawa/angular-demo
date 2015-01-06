<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeIngredient
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\FrontBundle\Entity\Repository\RecipeIngredientRepository")
 */
class RecipeIngredient
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Recipe")
     * @ORM\JoinColumn(name="recipe", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $recipe;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ingredient", inversedBy="recipeIngredients")
     * @ORM\JoinColumn(name="ingredient", referencedColumnName="id")
     */
    private $ingredient;

    /**
     * @ORM\Column(name="position", type="smallint")
     */
    private $position;

    /**
     * @ORM\Column(name="amount", type="smallint", nullable=true)
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="Measurement", inversedBy="recipeIngredients")
     * @ORM\JoinColumn(name="measurement", referencedColumnName="id", nullable=true)
     */
    private $measurement;

    /**
     * Set position
     *
     * @param integer $position
     * @return RecipeIngredient
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     * @return RecipeIngredient
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set recipe
     *
     * @param \Barra\FrontBundle\Entity\Recipe $recipe
     * @return RecipeIngredient
     */
    public function setRecipe(\Barra\FrontBundle\Entity\Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \Barra\FrontBundle\Entity\Recipe 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set ingredient
     *
     * @param \Barra\FrontBundle\Entity\Ingredient $ingredient
     * @return RecipeIngredient
     */
    public function setIngredient(\Barra\FrontBundle\Entity\Ingredient $ingredient)
    {
        $this->ingredient = $ingredient;

        return $this;
    }

    /**
     * Get ingredient
     *
     * @return \Barra\FrontBundle\Entity\Ingredient 
     */
    public function getIngredient()
    {
        return $this->ingredient;
    }

    /**
     * Set measurement
     *
     * @param \Barra\FrontBundle\Entity\Measurement $measurement
     * @return RecipeIngredient
     */
    public function setMeasurement(\Barra\FrontBundle\Entity\Measurement $measurement = null)
    {
        $this->measurement = $measurement;

        return $this;
    }

    /**
     * Get measurement
     *
     * @return \Barra\FrontBundle\Entity\Measurement 
     */
    public function getMeasurement()
    {
        return $this->measurement;
    }
}
