<?php

namespace Barra\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\DefaultBundle\Entity\ProductRepository")
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(name="weight", type="decimal", scale=2)
     */
    private $weight;

    /**
     * @ORM\Column(name="kcal integer", type="integer")
     */
    private $kcalInteger;

    /**
     * @ORM\Column(name="carbs", type="decimal")
     */
    private $carbs;

    /**
     * @ORM\Column(name="protein", type="decimal")
     */
    private $protein;

    /**
     * @ORM\Column(name="fat", type="decimal")
     */
    private $fat;

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
     * @return Product
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
     * Set kcalInteger
     *
     * @param integer $kcalInteger
     * @return Product
     */
    public function setKcalInteger($kcalInteger)
    {
        $this->kcalInteger = $kcalInteger;

        return $this;
    }

    /**
     * Get kcalInteger
     *
     * @return integer 
     */
    public function getKcalInteger()
    {
        return $this->kcalInteger;
    }

    /**
     * Set carbs
     *
     * @param string $carbs
     * @return Product
     */
    public function setCarbs($carbs)
    {
        $this->carbs = $carbs;

        return $this;
    }

    /**
     * Set weight
     *
     * @param string $weight
     * @return Product
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Get carbs
     *
     * @return string
     */
    public function getCarbs()
    {
        return $this->carbs;
    }

    /**
     * Set protein
     *
     * @param string $protein
     * @return Product
     */
    public function setProtein($protein)
    {
        $this->protein = $protein;

        return $this;
    }

    /**
     * Get protein
     *
     * @return string
     */
    public function getProtein()
    {
        return $this->protein;
    }

    /**
     * Set fat
     *
     * @param string $fat
     * @return Product
     */
    public function setFat($fat)
    {
        $this->fat = $fat;

        return $this;
    }

    /**
     * Get fat
     *
     * @return string
     */
    public function getFat()
    {
        return $this->fat;
    }


    /**
     * Set recipe
     *
     * @param \Barra\DefaultBundle\Entity\Recipe $recipe
     * @return Product
     */
    public function setRecipe(\Barra\DefaultBundle\Entity\Recipe $recipe = null)
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
