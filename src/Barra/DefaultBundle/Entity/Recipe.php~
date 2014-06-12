<?php

namespace Barra\DefaultBundle\Entity;

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
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=30, unique=true, nullable=false)
     */
    private $name;

    /**
     * @var integer
     * @ORM\Column(name="rating", type="smallint", nullable=false)
     */
    private $rating;

    /**
     * @var integer
     * @ORM\Column(name="votes", type="integer", nullable=false)
     */
    private $votes;

    /**
     * @var string
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     * @return Recipe
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return integer 
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Set votes
     *
     * @param integer $votes
     * @return Recipe
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * Get votes
     *
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
     * Add recipeIngredient
     *
     * @param \Barra\DefaultBundle\Entity\RecipeIngredient $recipeIngredient
     * @return Recipe
     */
    public function addRecipeIngredient(\Barra\DefaultBundle\Entity\RecipeIngredient $recipeIngredient)
    {
        $this->recipeIngredient[] = $recipeIngredient;

        return $this;
    }

    /**
     * Remove recipeIngredient
     *
     * @param \Barra\DefaultBundle\Entity\RecipeIngredient $recipeIngredient
     */
    public function removeRecipeIngredient(\Barra\DefaultBundle\Entity\RecipeIngredient $recipeIngredient)
    {
        $this->recipeIngredient->removeElement($recipeIngredient);
    }

    /**
     * Get recipeIngredient
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipeIngredient()
    {
        return $this->recipeIngredient;
    }
}
