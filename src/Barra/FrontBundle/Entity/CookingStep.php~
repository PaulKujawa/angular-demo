<?php

namespace Barra\DefaultBundle\Entity;

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
     * @var integer
     * @ORM\Id
     * @ORM\Column(name="step", type="smallint", nullable=false)
     */
    private $step;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Recipe")
     * @ORM\JoinColumn(name="recipe", referencedColumnName="id", nullable=false)
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
     * @param \Barra\DefaultBundle\Entity\Recipe $recipe
     * @return Cooking
     */
    public function setRecipe(\Barra\DefaultBundle\Entity\Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \Barra\DefaultBundle\Entity\Recipe 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }
}
