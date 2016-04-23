<?php

namespace Barra\RecipeBundle\Entity;

use Barra\RecipeBundle\Entity\Traits\IdAutoTrait;
use Barra\RecipeBundle\Entity\Traits\PositionTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity({
 *      "recipe",
 *      "product"
 * })
 * @UniqueEntity({
 *      "recipe",
 *      "position"
 * })
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass = "Barra\RecipeBundle\Entity\Repository\RecipeRelatedRepository")
 */
class Ingredient
{
    use IdAutoTrait;
    use PositionTrait;

    /**
     * @var Recipe
     *
     * @Assert\NotNull()
     *
     * @Exclude
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Recipe",
     *      inversedBy   = "ingredients"
     * )
     * @ORM\JoinColumn(
     *      name                 = "recipe",
     *      referencedColumnName = "id",
     *      nullable             = false,
     *      onDelete             = "CASCADE"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $recipe;

    /**
     * @var Product
     *
     * @Assert\NotNull()
     *
     * @Exclude
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Product",
     *      inversedBy   = "ingredients"
     * )
     * @ORM\JoinColumn(
     *      name                 = "product",
     *      referencedColumnName = "id"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $product;

    /**
     * @var int
     *
     * @Assert\GreaterThan(
     *      value = 0
     * )
     *
     * @ORM\Column(
     *      name     = "amount",
     *      type     = "smallint",
     *      nullable = true
     * )
     */
    private $amount;

    /**
     * @var Measurement
     *
     * @Exclude
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Measurement",
     *      inversedBy   = "ingredients"
     * )
     * @ORM\JoinColumn(
     *      name                 = "measurement",
     *      referencedColumnName = "id",
     *      nullable             = true
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $measurement;

    /**
     * @param Recipe $recipe
     *
     * @return $this
     */
    public function setRecipe(Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * @param int $amount
     *
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param Product $product
     *
     * @return $this
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Measurement $measurement
     *
     * @return $this
     */
    public function setMeasurement(Measurement $measurement)
    {
        $this->measurement = $measurement;

        return $this;
    }

    /**
     * @return Measurement
     */
    public function getMeasurement()
    {
        return $this->measurement;
    }

    /**
     * @return bool
     */
    public function isRemovable()
    {
        return true;
    }
}
