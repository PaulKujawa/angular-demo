<?php

namespace Barra\FrontBundle\Entity;

use Barra\FrontBundle\Entity\Traits\IdAutoTrait;
use Barra\FrontBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Product
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity

 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\FrontBundle\Entity\Repository\ProductRepository")
 */
class Product
{
    use NameTrait,
        IdAutoTrait
    ;

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
     * @var int
     * @ORM\Column(
     *      name  = "kcal",
     *      type  = "integer"
     * )
     */
    private $kcal;

    /**
     * @var double
     * @ORM\Column(
     *      name  = "protein",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $protein;

    /**
     * @var double
     * @ORM\Column(
     *      name  = "carbs",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $carbs;

    /**
     * @var double
     * @ORM\Column(
     *      name  = "sugar",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $sugar;

    /**
     * @var double
     * @ORM\Column(
     *      name  = "fat",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $fat;

    /**
     * @var double
     * @ORM\Column(
     *      name  = "gfat",
     *      type  = "decimal",
     *      scale = 1
     * )
     */
    private $gfat;

    /**
     * @var Manufacturer
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
     * @var ArrayCollection
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
        $recipes = [];
        foreach ($this->getIngredients() as $relation) {
            $recipes[] = $relation->getRecipe();
        }
        return $recipes;
    }

    /**
     * Set vegan
     *
     * @param boolean $vegan
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setVegan($vegan)
    {
        if (!is_bool($vegan)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'vegan',
                'bool'
            ));
        }
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
     * @param int $kcal
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setKcal($kcal)
    {
        if (!is_int($kcal)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'kcal',
                'int'
            ));
        }
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
     * @param int $gr
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setGr($gr)
    {
        if (!is_int($gr)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'gr',
                'int'
            ));
        }
        $this->gr = $gr;

        return $this;
    }

    /**
     * Get gr
     *
     * @return int
     */
    public function getGr()
    {
        return $this->gr;
    }

    /**
     * Set protein
     *
     * @param double $protein
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setProtein($protein)
    {
        if (!is_double($protein)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'protein',
                'double'
            ));
        }
        $this->protein = $protein;

        return $this;
    }

    /**
     * Get protein
     *
     * @return double
     */
    public function getProtein()
    {
        return $this->protein;
    }

    /**
     * Set carbs
     *
     * @param double $carbs
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setCarbs($carbs)
    {
        if (!is_double($carbs)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'carbs',
                'double'
            ));
        }
        $this->carbs = $carbs;

        return $this;
    }

    /**
     * Get carbs
     *
     * @return double
     */
    public function getCarbs()
    {
        return $this->carbs;
    }

    /**
     * Set sugar
     *
     * @param double $sugar
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setSugar($sugar)
    {
        if (!is_double($sugar)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'sugar',
                'double'
            ));
        }
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
     * @param double $fat
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setFat($fat)
    {
        if (!is_double($fat)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'fat',
                'double'
            ));
        }
        $this->fat = $fat;

        return $this;
    }

    /**
     * Get fat
     *
     * @return double
     */
    public function getFat()
    {
        return $this->fat;
    }

    /**
     * Set gfat
     *
     * @param double $gfat
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setGfat($gfat)
    {
        if (!is_double($gfat)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'gfat',
                'double'
            ));
        }
        $this->gfat = $gfat;

        return $this;
    }

    /**
     * Get gfat
     *
     * @return double
     */
    public function getGfat()
    {
        return $this->gfat;
    }

    /**
     * Set manufacturer
     *
     * @param Manufacturer $manufacturer
     * @return $this
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
     * @return $this
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
