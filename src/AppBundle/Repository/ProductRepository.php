<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Product;
use AppBundle\Model\PaginationResponse;
use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use AppBundle\Service\PaginationResponseFactory;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class ProductRepository
{
    const PAGE_LIMIT = 5;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PaginationResponseFactory
     */
    private $paginationResponseFactory;

    /**
     * @param EntityManager $entityManager
     * @param PaginationResponseFactory $paginationResponseFactory
     */
    public function __construct(
        EntityManager $entityManager,
        PaginationResponseFactory $paginationResponseFactory
    ) {
        $this->entityManager= $entityManager;
        $this->paginationResponseFactory = $paginationResponseFactory;
    }

    /**
     * @param int $page
     * @param QueryDecorator $queryDecorator
     *
     * @return PaginationResponse
     */
    public function getProducts(int $page, QueryDecorator $queryDecorator = null): PaginationResponse
    {
        $repository = $this->entityManager->getRepository(Product::class);
        $firstResult = ($page - 1) * self::PAGE_LIMIT;
        $criteria = Criteria::create();

        if ($queryDecorator) {
            $queryDecorator->decorate($criteria);
        }

        try {
            $products = $repository->matching($criteria);
        } catch (ORMException $exception) {
            $products = [];
        }

        // TODO workaround with shitty performance! Criteria misses support for count yet!
        $docs = array_values($products->slice($firstResult, self::PAGE_LIMIT));

        $paginationResponse = $this->paginationResponseFactory->createPaginationResponse(
            $docs,
            $products->count(),
            self::PAGE_LIMIT,
            $page
        );

        return $paginationResponse;
    }

    /**
     * @param int $id
     *
     * @return Product|null
     */
    public function getProduct(int $id)
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
