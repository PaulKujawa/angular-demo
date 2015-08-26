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
     * @param integer $amount
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer 
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
     * @return $this
     */
    public function createId()
    {
        $this->id = $this->getRecipe()->getId() . $this->getProduct()->getId();

        return $this;
    }


    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
