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
    const PAGE_LIMIT = 10;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var PaginationResponseFactory
     */
    private $paginationResponseFactory;

    public function __construct(
        EntityManager $entityManager,
        PaginationResponseFactory $paginationResponseFactory
    ) {
        $this->entityManager= $entityManager;
        $this->paginationResponseFactory = $paginationResponseFactory;
    }

    public function getProducts(int $page, QueryDecorator $queryDecorator = null): PaginationResponse
    {
        $criteria = Criteria::create();
        $criteria->setFirstResult(self::PAGE_LIMIT * ($page - 1));
        $criteria->setMaxResults(self::PAGE_LIMIT);

        if ($queryDecorator) {
            $queryDecorator->decorate($criteria);
        }

        $repository = $this->entityManager->getRepository(Product::class);

        try {
            $products = $repository->matching($criteria);
        } catch (ORMException $exception) {
            $products = [];
        }

        $paginationResponse = $this->paginationResponseFactory->createPaginationResponse(
            $products->toArray(),
            7, // TODO request and cache this value
            $page
        );

        return $paginationResponse;
    }

    public function getProduct(int $id): ?Product
    {
        return $this->entityManager->getRepository(Product::class)->find($id);
    }

    public function addProduct(Product $product): Product
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush($product);

        return $product;
    }

    public function setProduct(Product $product): void
    {
        $this->entityManager->flush($product);
    }

    public function deleteProduct(Product $product): void
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush($product);
    }
}
