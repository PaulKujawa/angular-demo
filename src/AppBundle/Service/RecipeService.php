<?php

namespace AppBundle\Service;

use AppBundle\Entity\Recipe;
use AppBundle\Model\Pagination;
use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class RecipeService
{
    const PAGE_LIMIT = 4;

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
            ->select('count(r.id)')
            ->from(Recipe::class, 'r')
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
     * @return Recipe[]
     */
    public function getRecipes($page, QueryDecorator $queryDecorator = null)
    {
        $firstResult = ($page - 1) * self::PAGE_LIMIT;

        $criteria = Criteria::create()
            ->setFirstResult($firstResult)
            ->setMaxResults(self::PAGE_LIMIT);

        if ($queryDecorator) {
            $queryDecorator->decorate($criteria);
        }

        $repository = $this->entityManager->getRepository(Recipe::class);

        try {
            return $repository->matching($criteria)->toArray();
        } catch (ORMException $exception) {
            return [];
        }
    }

    /**
     * @param int $id
     *
     * @return Recipe|null
     */
    public function getRecipe($id)
    {
        return $this->entityManager->getRepository(Recipe::class)->find($id);
    }

    /**
     * @param Recipe $recipe
     *
     * @return Recipe
     */
    public function addRecipe(Recipe $recipe)
    {
        $this->entityManager->persist($recipe);
        $this->entityManager->flush($recipe);

        return $recipe;
    }

    /**
     * @param Recipe $recipe
     */
    public function setRecipe(Recipe $recipe)
    {
        $this->entityManager->flush($recipe);
    }

    /**
     * @param Recipe $recipe
     */
    public function deleteRecipe(Recipe $recipe)
    {
        $this->entityManager->remove($recipe);
        $this->entityManager->flush($recipe);
    }
}
