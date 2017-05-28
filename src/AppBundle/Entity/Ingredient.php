<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\PositionTrait;
use AppBundle\Entity\Traits\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
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
 * @ORM\HasLifecycleCallbacks()
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
     * @Serializer\Exclude()
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
    public $recipe;

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
    public $product;

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
    public $amount;

    /**
     * @var Measurement
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Measurement",
     *      inversedBy = "ingredients"
     * )
     * @ORM\JoinColumn(
     *      name = "measurement",
     *      referencedColumnName = "id"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    public $measurement;

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("kcal")
     *
     * @return int
     */
    public function calculateKcal(): int
    {
        if (null === $this->amount) {
            return 0;
        }

        $kcal = $this->getRelation() * $this->product->kcal;

        return (int)($kcal);
    }

    /**
     * @return float
     */
    private function getRelation(): float {
        $gr = $this->measurement->gr ?: $this->product->gr;

        return $this->amount * $gr / 100;
    }
}
