<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Measurement
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\FrontBundle\Entity\Repository\MeasurementRepository")
 */
class Measurement
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="type", type="string", length=10, unique=true)
     */
    private $type;

    /**
     * @ORM\Column(name="gr", type="smallint")
     */
    private $gr;

    /**
     * @ORM\OneToMany(targetEntity="RecipeIngredient", mappedBy="measurement")
     */
    private $recipeIngredients;

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
     * Set typ
     *
     * @param string $typ
     * @return Measurement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get typ
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set gr
     *
     * @param integer $gr
     * @return Measurement
     */
    public function setGr($gr)
    {
        $this->gr = $gr;

        return $this;
    }

    /**
     * Get gr
     *
     * @return integer 
     */
    public function getGr()
    {
        return $this->gr;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipeIngredients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add recipeIngredients
     *
     * @param \Barra\FrontBundle\Entity\RecipeIngredient $recipeIngredients
     * @return Measurement
     */
    public function addRecipeIngredient(\Barra\FrontBundle\Entity\RecipeIngredient $recipeIngredients)
    {
        $this->recipeIngredients[] = $recipeIngredients;

        return $this;
    }

    /**
     * Remove recipeIngredients
     *
     * @param \Barra\FrontBundle\Entity\RecipeIngredient $recipeIngredients
     */
    public function removeRecipeIngredient(\Barra\FrontBundle\Entity\RecipeIngredient $recipeIngredients)
    {
        $this->recipeIngredients->removeElement($recipeIngredients);
    }

    /**
     * Get recipeIngredients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipeIngredients()
    {
        return $this->recipeIngredients;
    }
}
