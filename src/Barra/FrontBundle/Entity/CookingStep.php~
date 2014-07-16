<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cooking
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class CookingStep
{
    /**
     * @ORM\Id
     * @ORM\Column(name="step", type="smallint", nullable=false)
     */
    private $step;

    /**
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Recipe")
     * @ORM\JoinColumn(name="recipe", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $recipe;

    /**
     * Set step
     *
     * @param integer $step
     * @return Cooking
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return integer 
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Cooking
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set recipe
     *
     * @param \Barra\FrontBundle\Entity\Recipe $recipe
     * @return Cooking
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
}
