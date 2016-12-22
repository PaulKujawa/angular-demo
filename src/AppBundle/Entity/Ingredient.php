<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\PositionTrait;
use AppBundle\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
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
 * @ORM\Entity(repositoryClass = "AppBundle\Entity\Repository\RecipeRelatedRepository")
 */
class Ingredient
{
    use IdAutoTrait;
    use PositionTrait;
    use TimestampTrait;

    /**
     * @param int $recipeId
     * @param int $position
     */
    public function __construct(int $recipeId, int $position)
    {
        $this->recipe = $recipeId;
        $this->position = $position;
    }

    /**
     * @var Recipe
     *
     * @Assert\NotNull()
     *
     * @Exclude
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Recipe",
     *      inversedBy = "ingredients"
     * )
     * @ORM\JoinColumn(
     *      name = "recipe",
     *      referencedColumnName = "id",
     *      nullable = false,
     *      onDelete = "CASCADE"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $recipe;

    /**
     * @var Product
     *
     * @Assert\NotNull()
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Product",
     *      inversedBy = "ingredients"
     * )
     * @ORM\JoinColumn(
     *      name = "product",
     *      referencedColumnName = "id"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $product;

    /**
     * @var int
     *
     * @Assert\GreaterThan(value = 0)
     *
     * @ORM\Column(
     *      type = "smallint",
     *      nullable = true
     * )
     */
    private $amount;

    /**
     * @var Measurement
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Measurement",
     *      inversedBy = "ingredients"
     * )
     * @ORM\JoinColumn(
     *      name = "measurement",
     *      referencedColumnName = "id",
     *      nullable = true
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $measurement;

    /**
     * @param Recipe $recipe
     */
    public function setRecipe(Recipe $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * @return Recipe
     */
    public function getRecipe(): Recipe
    {
        return $this->recipe;
    }

    /**
     * @param int $amount
     */
    public function setAmount(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return int|null
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Measurement $measurement
     */
    public function setMeasurement(Measurement $measurement)
    {
        $this->measurement = $measurement;
    }

    /**
     * @return Measurement
     */
    public function getMeasurement(): Measurement
    {
        return $this->measurement;
    }
}
