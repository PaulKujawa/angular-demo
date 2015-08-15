<?php

namespace Barra\FrontBundle\Entity;

use Barra\FrontBundle\Entity\Traits\IdAutoTrait;
use Barra\FrontBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Product
 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\FrontBundle\Entity\Repository\ProductRepository")
 */
class Product
{
    use NameTrait;
    use IdAutoTrait;

    /**
     * @var bool
     * @ORM\Column(
     *      name = "vegan",
     *      type = "boolean"
     * )
     */
    private $vegan;

    /**
     * @var int
     * @ORM\Column(
     *      name = "gr",
     *      type = "smallint"
     * )
     */
    private $gr;

    /**
     * @var float
     * @ORM\Column(
     *      name  = "kcal",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $kcal;

    /**
     * @var float
     * @ORM\Column(
     *      name  = "protein",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $protein;

    /**
     * @var float
     * @ORM\Column(
     *      name  = "carbs",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $carbs;

    /**
     * @var float
     * @ORM\Column(
     *      name  = "sugar",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $sugar;

    /**
     * @var float
     * @ORM\Column(
     *      name  = "fat",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $fat;

    /**
     * @var float
     * @ORM\Column(
     *      name  = "gfat",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $gfat;

    /**
     * @ORM\ManyToOne(
     *      targetEntity = "Manufacturer",
     *      inversedBy   = "products"
     * )
     * @ORM\JoinColumn(
     *      name                 = "manufacturer",
     *      referencedColumnName = "id",
     *      nullable             = false
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $manufacturer;

    /**
     * @ORM\OneToMany(targetEntity="Ingredient", mappedBy="product")
     */
    private $ingredients;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    /**
     * Own method for direct access to using recipes
     */
    public function getRecipes()
    {
        $recipes = array();
        foreach ($this->getIngredients() as $relation) {
            $recipes[] = $relation->getRecipe();
        }
        return $recipes;
    }

    /**
     * Set vegan
     *
     * @param boolean $vegan
     * @return Product
     */
    public function setVegan($vegan)
    {
        $this->vegan = $vegan;

        return $this;
    }

    /**
     * Get vegan
     *
     * @return boolean 
     */
    public function getVegan()
    {
        return $this->vegan;
    }

    /**
     * Set kcal
     *
     * @param string $kcal
     * @return Product
     */
    public function setKcal($kcal)
    {
        $this->kcal = $kcal;

        return $this;
    }

    /**
     * Get kcal
     *
     * @return string 
     */
    public function getKcal()
    {
        return $this->kcal;
    }

    /**
     * Set gr
     *
     * @param integer $gr
     * @return Product
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
     * Get carbs
     *
     * @return string 
     */
    public function getCarbs()
    {
        return $this->carbs;
    }

    /**
     * Set sugar
     *
     * @param string $sugar
     * @return Product
     */
    public function setSugar($sugar)
    {
        $this->sugar = $sugar;

        return $this;
    }

    /**
     * Get sugar
     *
     * @return string 
     */
    public function getSugar()
    {
        return $this->sugar;
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
     * Set gfat
     *
     * @param string $gfat
     * @return Product
     */
    public function setGfat($gfat)
    {
        $this->gfat = $gfat;

        return $this;
    }

    /**
     * Get gfat
     *
     * @return string 
     */
    public function getGfat()
    {
        return $this->gfat;
    }

    /**
     * Set manufacturer
     *
     * @param Manufacturer $manufacturer
     * @return Product
     */
    public function setManufacturer(Manufacturer $manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Add ingredient
     *
     * @param Ingredient $ingredient
     * @return Product
     */
    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param Ingredient $ingredient
     */
    public function removeIngredient(Ingredient $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Get ingredients
     *
     * @return ArrayCollection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
}
