<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Manufacturer
 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\FrontBundle\Entity\Repository\ManufacturerRepository")
 */
class Manufacturer
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *@ORM\Column(name="name", type="string", length=30, unique=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="manufacturer")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $ingredients;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return Manufacturer
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
     * @return Manufacturer
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
