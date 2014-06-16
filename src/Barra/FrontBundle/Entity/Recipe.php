<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Recipe
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30, unique=true, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="rating", type="smallint", nullable=false)
     */
    private $rating;

    /**
     * @ORM\Column(name="votes", type="integer", nullable=false)
     */
    private $votes;

    /**
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="Recipe")
     */
    private $recipeIngredient;


    /**
     * Own shortcut-method for direct access to related recipes
     * @return array
     */
    public function getIngredients()
    {
        $ingredients = array();

         foreach ($this->getRecipeIngredient() as $recipeIngredient) {
        //    $ingredients[] = $recipeIngredient->getIngredients();
         }

        // return $ingredients;
        return 1;
    }







    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param integer $rating
     * @return Recipe
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param integer $votes
     * @return Recipe
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * @return integer
     */
    public function getVotes()
    {
        return $this->votes;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipeIngredient = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @param \Barra\FrontBundle\Entity\RecipeIngredient $recipeIngredient
     * @return Recipe
     */
    public function addRecipeIngredient(\Barra\FrontBundle\Entity\RecipeIngredient $recipeIngredient)
    {
        $this->recipeIngredient[] = $recipeIngredient;

        return $this;
    }

    /**
     * @param \Barra\FrontBundle\Entity\RecipeIngredient $recipeIngredient
     */
    public function removeRecipeIngredient(\Barra\FrontBundle\Entity\RecipeIngredient $recipeIngredient)
    {
        $this->recipeIngredient->removeElement($recipeIngredient);
    }

    /**
    * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipeIngredient()
    {
        return $this->recipeIngredient;
    }
}
