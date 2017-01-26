<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\TimestampTrait;
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
 * @ORM\HasLifecycleCallbacks()
 */
class Recipe
{
    use IdAutoTrait;
    use NameTrait;
    use TimestampTrait;

    /**
     * @var bool
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(
     *     name = "isVegan",
     *     type = "boolean"
     * )
     */
    public $isVegan;

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
    public $thumbnail;

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
    public $ingredients;

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
    public $cookings;

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
    public $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->cookings = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function generateIsVegan()
    {
        $notVeganProducts = $this->ingredients->filter(function(Ingredient $ingredient) {
            return !$ingredient->product->vegan;
        });

        $this->isVegan = $notVeganProducts->count() === 0;
    }

    /**
     * docs: Array<Recipe>TODO should be done as db-entity property
     *
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("macros")
     *
     * @return array
     */
    public function calculateMacros(): array
    {
        $macros = [
            'kcal' => 0,
            'carbs' => 0,
            'protein' => 0,
            'fat' => 0,
        ];

        $ingredients = $this->ingredients->filter(function(Ingredient $ingredient) {
            return null !== $ingredient->amount;
        });

        /**
         * @var Ingredient $ingredient
         */
        foreach ($ingredients as $ingredient) {
            $rel = $this->getMeasurementRelation($ingredient);
            $product = $ingredient->product;
            $macros['kcal'] += $rel*$product->kcal;
            $macros['carbs'] += $rel*$product->carbs;
            $macros['protein'] += $rel*$product->protein;
            $macros['fat'] += $rel*$product->fat;
        }

        return array_map('intval', $macros);
    }

    /**
     * @param Ingredient $ingredient
     *
     * @return float
     */
    private function getMeasurementRelation(Ingredient $ingredient): float {
        $gr = $ingredient->measurement->gr ?: $ingredient->product->gr;

        return $ingredient->amount * $gr / 100;
    }
}
