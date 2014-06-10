<?php

namespace Barra\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\DefaultBundle\Entity\RecipeRepository")
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
     * @var integer
     * @ORM\OneToOne(targetEntity="RecipeIngredient")
     * @ORM\JoinColumn(name="mainIngredient", referencedColumnName="id")
     **/
    private $mainIngredient;


    /**
     * @var string
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="Recipe")
     */
    private $ingredients;


    /**ß
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
     * Set ingredients
     *
     * @param string $ingredients
     * @return Recipe
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * Get ingredients
     *
     * @return string 
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Set mainIngredient
     *
     * @param \Barra\DefaultBundle\Entity\RecipeIngredient $mainIngredient
     * @return Recipe
     */
    public function setMainIngredient(\Barra\DefaultBundle\Entity\RecipeIngredient $mainIngredient = null)
    {
        $this->mainIngredient = $mainIngredient;

        return $this;
    }

    /**
     * Get mainIngredient
     *
     * @return \Barra\DefaultBundle\Entity\RecipeIngredient 
     */
    public function getMainIngredient()
    {
        return $this->mainIngredient;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ingredients
     *
     * @param \Barra\DefaultBundle\Entity\RecipeIngredient $ingredients
     * @return Recipe
     */
    public function addIngredient(\Barra\DefaultBundle\Entity\RecipeIngredient $ingredients)
    {
        $this->ingredients[] = $ingredients;

        return $this;
    }

    /**
     * Remove ingredients
     *
     * @param \Barra\DefaultBundle\Entity\RecipeIngredient $ingredients
     */
    public function removeIngredient(\Barra\DefaultBundle\Entity\RecipeIngredient $ingredients)
    {
        $this->ingredients->removeElement($ingredients);
    }
}
