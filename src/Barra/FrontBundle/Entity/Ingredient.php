<?php

namespace Barra\FrontBundle\Entity;

use Barra\FrontBundle\Entity\Traits\PositionTrait;
use Barra\FrontBundle\Entity\Traits\RecipeTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Ingredient
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity
 *
 * @ExclusionPolicy("none")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\FrontBundle\Entity\Repository\IngredientRepository")
 */
class Ingredient
{
    use PositionTrait,
        RecipeTrait
    ;

    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(
     *      name = "id",
     *      type = "integer"
     * )
     */
    protected $id;

    /**
     * @var Product
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
     * @ORM\Column(
     *      name     = "amount",
     *      type     = "smallint",
     *      nullable = true
     * )
     */
    private $amount;

    /**
     * @var Measurement
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
     * Set amount
     *
     * @param int $amount
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setAmount($amount)
    {
        if (!is_int($amount)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'amount',
                'int'
            ));
        }
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set product
     *
     * @param Product $product
     * @return $this
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set measurement
     *
     * @param Measurement $measurement
     * @return $this
     */
    public function setMeasurement(Measurement $measurement)
    {
        $this->measurement = $measurement;

        return $this;
    }

    /**
     * Get measurement
     *
     * @return Measurement
     */
    public function getMeasurement()
    {
        return $this->measurement;
    }


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @return $this
     * @throws \RuntimeException
     */
    public function createId()
    {
        if (is_null($this->getRecipe()) ||
            is_null($this->getRecipe()->getId()) ||
            is_null($this->getProduct()) ||
            is_null($this->getProduct()->getId())
        ) {
            throw new \RuntimeException(sprintf(
                '"%s" and "%s" must have been set',
                'recipe',
                'product'
            ));
        }
        $this->id = $this->getRecipe()->getId() . $this->getProduct()->getId();

        return $this;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
