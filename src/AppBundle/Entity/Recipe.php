<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Recipe
{
    use IdAutoTrait;
    use NameTrait;

    /**
     * @var Photo
     *
     * @Assert\NotNull()
     *
     * @Serializer\Groups({"recipeList"})
     *
     * @ORM\OneToOne(targetEntity = "Photo")
     * @ORM\JoinColumn(
     *      name = "thumbnail",
     *      referencedColumnName = "id"
     * )
     */
    private $thumbnail;

    /**
     * @var ArrayCollection
     *
     * @Serializer\Groups({"recipeDetail"})
     *
     * @ORM\OneToMany(
     *      targetEntity = "Ingredient",
     *      mappedBy = "recipe"
     * )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $ingredients;

    /**
     * @var ArrayCollection
     *
     * @Serializer\Groups({"recipeDetail"})
     *
     * @ORM\OneToMany(
     *      targetEntity = "Cooking",
     *      mappedBy = "recipe"
     * )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $cookings;

    /**
     * @var ArrayCollection
     *
     * @Serializer\Groups({"recipeDetail"})

     * @ORM\OneToMany(
     *      targetEntity = "Photo",
     *      mappedBy = "recipe",
     *      cascade = {"remove"}
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->cookings = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("isVegan")
     *
     * @return bool
     */
    public function isVegan()
    {
        // TODO add as native db table column instead for better performance
        $notVeganProducts = $this->ingredients->filter(function(Ingredient $ingredient) {
            return !$ingredient->getProduct()->getVegan();
        });

        return $notVeganProducts->count() === 0;
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("macros")
     *
     * @return array
     */
    public function calculateMacros()
    {
        $macros = [
            'kcal' => 0,
            'carbs' => 0,
            'protein' => 0,
            'fat' => 0,
        ];

        $ingredients = $this->ingredients->filter(function(Ingredient $ingredient) {
            return null !== $ingredient->getAmount();
        });

        /**
         * @var Ingredient $ingredient
         */
        foreach ($ingredients as $ingredient) {
            $rel = $this->getMeasurementRelation($ingredient);
            $product = $ingredient->getProduct();
            $macros['kcal'] += $rel*$product->getKcal();
            $macros['carbs'] += $rel*$product->getCarbs();
            $macros['protein'] += $rel*$product->getProtein();
            $macros['fat'] += $rel*$product->getFat();
        }

        return array_map('intval', $macros);
    }

    /**
     * @param Ingredient $ingredients
     */
    public function addIngredient(Ingredient $ingredients)
    {
        $this->ingredients[] = $ingredients;
    }

    /**
     * @param Ingredient $cooking
     */
    public function removeIngredient(Ingredient $cooking)
    {
        $this->ingredients->removeElement($cooking);
    }

    /**
     * @return ArrayCollection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param Cooking $cooking
     */
    public function addCooking(Cooking $cooking)
    {
        $this->cookings[] = $cooking;
    }

    /**
     * @param Cooking $cooking
     */
    public function removeCooking(Cooking $cooking)
    {
        $this->cookings->removeElement($cooking);
    }

    /**
     * @return ArrayCollection
     */
    public function getCookings()
    {
        return $this->cookings;
    }

    /**
     * @param Photo $photos
     */
    public function addPhoto(Photo $photos)
    {
        $this->photos[] = $photos;
    }

    /**
     * @param Photo $photos
     */
    public function removePhoto(Photo $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * @return ArrayCollection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @return Photo
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param Photo $thumbnail
     */
    public function setThumbnail(Photo $thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @param Ingredient $ingredient
     * @return float
     */
    private function getMeasurementRelation(Ingredient $ingredient) {
        $gr = $ingredient->getMeasurement()->getGr()
            ? $ingredient->getAmount()/100
            : $ingredient->getProduct()->getGr();

        return $gr/100;
    }
}
