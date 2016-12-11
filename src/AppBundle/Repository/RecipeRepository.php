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
    public function getRecipes($page, QueryDecorator $queryDecorator = null)
    {
        $repository = $this->entityManager->getRepository(Recipe::class);
        $firstResult = ($page - 1) * self::PAGE_LIMIT;
        $criteria = Criteria::create();

        if ($queryDecorator) {
            $queryDecorator->decorate($criteria);
        }

        try {
            $recipes = $repository->matching($criteria);
        } catch (ORMException $exception) {
            $recipes = [];
        }

        // TODO workaround with shitty performance! Criteria misses support for count yet!
        $docs = array_values($recipes->slice($firstResult, self::PAGE_LIMIT));

        $paginationResponse = $this->paginationResponseFactory->createPaginationResponse(
            $docs,
            $recipes->count(),
            self::PAGE_LIMIT,
            $page
        );

        return $paginationResponse;
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
