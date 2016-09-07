<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Product
{
    use IdAutoTrait;
    use NameTrait;

    /**
     * @var bool
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(
     *      name = "vegan",
     *      type = "boolean"
     * )
     */
    private $vegan;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\GreaterThan(value = 0)
     *
     * @ORM\Column(
     *      name = "gr",
     *      type = "smallint"
     * )
     */
    private $gr;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\GreaterThan(value = 0)
     *
     * @ORM\Column(
     *      name = "kcal",
     *      type = "integer"
     * )
     */
    private $kcal;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      name = "protein",
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $protein;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      name = "carbs",
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $carbs;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      name = "sugar",
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $sugar;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      name = "fat",
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $fat;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      name = "gfat",
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $gfat;

    /**
     * @var Manufacturer
     *
     * @Assert\NotNull()
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Manufacturer",
     *      inversedBy = "products"
     * )
     * @ORM\JoinColumn(
     *      name = "manufacturer",
     *      referencedColumnName = "id",
     *      nullable = false
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $manufacturer;

    /**
     * @var ArrayCollection
     *
     * @Exclude
     *
     * @ORM\OneToMany(
     *      targetEntity = "Ingredient",
     *      mappedBy = "product"
     * )
     */
    private $ingredients;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getRecipes()
    {
        return $this->getIngredients()->map(function(Ingredient $ingredient) {
            $ingredient->getRecipe();
        });
    }

    /**
     * @param boolean $vegan
     *
     * @return $this
     */
    public function setVegan($vegan)
    {
        $this->vegan = $vegan;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getVegan()
    {
        return $this->vegan;
    }


    /**
     * @param int $kcal
     *
     * @return $this
     */
    public function setKcal($kcal)
    {
        $this->kcal = $kcal;

        return $this;
    }

    /**
     * @return string
     */
    public function getKcal()
    {
        return $this->kcal;
    }

    /**
     * @param int $gr
     *
     * @return $this
     */
    public function setGr($gr)
    {
        $this->gr = $gr;

        return $this;
    }

    /**
     * @return int
     */
    public function getGr()
    {
        return $this->gr;
    }

    /**
     * @param double $protein
     *
     * @return $this
     */
    public function setProtein($protein)
    {
        $this->protein = $protein;

        return $this;
    }

    /**
     * @return double
     */
    public function getProtein()
    {
        return $this->protein;
    }

    /**
     * @param double $carbs
     *
     * @return $this
     */
    public function setCarbs($carbs)
    {
        $this->carbs = $carbs;

        return $this;
    }

    /**
     * @return double
     */
    public function getCarbs()
    {
        return $this->carbs;
    }

    /**
     * @param double $sugar
     * @return $this
     */
    public function setSugar($sugar)
    {
        $this->sugar = $sugar;

        return $this;
    }

    /**
     * @return string
     */
    public function getSugar()
    {
        return $this->sugar;
    }

    /**
     * @param double $fat
     *
     * @return $this
     */
    public function setFat($fat)
    {
        $this->fat = $fat;

        return $this;
    }

    /**
     * @return double
     */
    public function getFat()
    {
        return $this->fat;
    }

    /**
     * @param double $gfat
     *
     * @return $this
     */
    public function setGfat($gfat)
    {
        $this->gfat = $gfat;

        return $this;
    }

    /**
     * @return double
     */
    public function getGfat()
    {
        return $this->gfat;
    }

    /**
     * @param Manufacturer $manufacturer
     *
     * @return $this
     */
    public function setManufacturer(Manufacturer $manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * @return Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * @param Ingredient $ingredient
     *
     * @return $this
     */
    public function addIngredient(Ingredient $ingredient)
    {
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * @param Ingredient $ingredient
     *
     * @return $this
     */
    public function removeIngredient(Ingredient $ingredient)
    {
        $this->ingredients->removeElement($ingredient);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }
}
