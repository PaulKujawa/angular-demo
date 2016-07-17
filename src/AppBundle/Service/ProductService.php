<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;

class ProductService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager= $entityManager;
    }

    /**
     * @param string $orderBy
     * @param string $order
     * @param int $limit
     * @param int $offset
     *
     * @return Product[]|array
     */
    public function getProducts($orderBy, $order, $limit, $offset)
    {
        return $this->entityManager->getRepository(Product::class)->findBy(
            [],
            [$orderBy => $order],
            $limit,
            $offset
        );
    }

    /**
     * @param int $id
     *
     * @return Product|null
     */
    public function getProduct($id)
    {
        return $this->entityManager->getRepository(Product::class)->find($id);
    }

    /**
     * @param Product $product
     *
     * @return Product
     */
    public function addProduct(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush($product);

        return $product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->entityManager->flush($product);
    }

    /**
     * @param Product $product
     */
    public function deleteProduct(Product $product)
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush($product);
    }
}
