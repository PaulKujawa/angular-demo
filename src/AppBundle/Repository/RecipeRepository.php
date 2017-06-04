<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Recipe;
use AppBundle\Model\PaginationResponse;
use AppBundle\RequestDecorator\Decorator\QueryDecorator;
use AppBundle\Service\PaginationResponseFactory;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

class RecipeRepository
{
    const PAGE_LIMIT = 20;

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
    public function getRecipes(int $page, QueryDecorator $queryDecorator = null): PaginationResponse
    {
        $criteria = Criteria::create();
        $criteria->setFirstResult(self::PAGE_LIMIT * ($page - 1));
        $criteria->setMaxResults(self::PAGE_LIMIT);

        if ($queryDecorator) {
            $queryDecorator->decorate($criteria);
        }

        $repository = $this->entityManager->getRepository(Recipe::class);

        try {
            $recipes = $repository->matching($criteria);
        } catch (ORMException $exception) {
            $recipes = [];
        }

        $paginationResponse = $this->paginationResponseFactory->createPaginationResponse(
            $recipes->toArray(),
            1, // todo mocked
            $page
        );

        return $paginationResponse;
    }

    /**
     * @param int $id
     *
     * @return Recipe|null
     */
    public function getRecipe(int $id)
    {
        return $this->entityManager->getRepository(Recipe::class)->find($id);
    }

    /**
     * @param Recipe $recipe
     *
     * @return Recipe
     */
    public function addRecipe(Recipe $recipe): Recipe
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
