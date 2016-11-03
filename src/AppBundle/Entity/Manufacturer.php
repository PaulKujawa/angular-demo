<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Manufacturer
{
    use IdAutoTrait;
    use NameTrait;

    /**
     * @var ArrayCollection
     *
     * @Serializer\Exclude()
     *
     * @ORM\OneToMany(
     *      targetEntity = "Product",
     *      mappedBy = "manufacturer"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @param Product $products
     */
    public function addProduct(Product $products)
    {
        $this->products[] = $products;
    }

    /**
     * @param Product $product
     */
    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * @return ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }
}
