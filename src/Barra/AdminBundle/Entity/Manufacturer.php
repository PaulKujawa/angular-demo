<?php

namespace Barra\AdminBundle\Entity;

use Barra\AdminBundle\Entity\Traits\IdAutoTrait;
use Barra\AdminBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Manufacturer
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity
 *
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\AdminBundle\Entity\Repository\ManufacturerRepository")
 */
class Manufacturer
{
    use IdAutoTrait,
        NameTrait
    ;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity = "Product",
     *      mappedBy     = "manufacturer"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $products;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @param Product $products
     * @return $this
     */
    public function addProduct(Product $products)
    {
        $this->products[] = $products;

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @return bool
     */
    public function isRemovable()
    {
        return $this->getProducts()->isEmpty();
    }
}
