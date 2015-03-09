<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Cooking
 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\FrontBundle\Entity\Repository\CookingStepRepository")
 */
class CookingStep
{
    /** no primary, because I could not update queries w/o transactions, which I'm not able to do with doctrine yet
     * @ORM\Column(name="position", type="smallint")
     */
    private $position;

    /**
     * @ORM\Id
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Recipe")
     * @ORM\JoinColumn(name="recipe", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $recipe;

    /**
     * Set position
     *
     * @param integer $position
     * @return Cooking
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
