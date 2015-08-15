<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Measurement
 * @ExclusionPolicy("none")
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
     * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="measurement")
     */
    private $ingredients;

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
        $this->ingredients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ingredients
     *
     * @param \Barra\FrontBundle\Entity\Ingredient $ingredients
     * @return Measurement
     */
    public function addIngredient(\Barra\FrontBundle\Entity\Ingredient $ingredients)
    {
        $this->ingredients[] = $ingredients;

        return $this;
    }

    /**
     * Remove ingredients
     *
     * @param \Barra\FrontBundle\Entity\Ingredient $ingredients
     */
    public function removeIngredient(\Barra\FrontBundle\Entity\Ingredient $ingredients)
    {
        $this->ingredients->removeElement($ingredients);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
}
