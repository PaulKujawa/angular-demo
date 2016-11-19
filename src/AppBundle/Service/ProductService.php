<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use AppBundle\Model\Pagination;
use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class ProductService
{
    const PAGE_LIMIT = 5;

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
     * @param int $page
     *
     * @return Pagination
     */
    public function getPagination($page)
    {
        $count = $this->entityManager->createQueryBuilder()
            ->select('count(p.id)')
            ->from(Product::class, 'p')
            ->getQuery()
            ->getSingleScalarResult();

        $pagination = new Pagination();
        $pagination->page = $page;
        $pagination->pages = ceil($count / self::PAGE_LIMIT);

        return $pagination;
    }

    /**
     * @param int $page
     * @param QueryDecorator $queryDecorator
     *
     * @return Product[]
     */
    public function getProducts($page, QueryDecorator $queryDecorator = null)
    {
        $firstResult = ($page - 1) * self::PAGE_LIMIT;

        $criteria = Criteria::create()
            ->setFirstResult($firstResult)
            ->setMaxResults(self::PAGE_LIMIT);

        if ($queryDecorator) {
            $queryDecorator->decorate($criteria);
        }

        $repository = $this->entityManager->getRepository(Product::class);

        try {
            return $repository->matching($criteria)->toArray();
        } catch (ORMException $exception) {
            return [];
        }
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
