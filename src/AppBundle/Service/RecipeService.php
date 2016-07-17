<?php

namespace AppBundle\Service;

use AppBundle\Entity\Recipe;
use Doctrine\ORM\EntityManager;

class RecipeService
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
     * @return Recipe[]|array
     */
    public function getRecipes($orderBy, $order, $limit, $offset)
    {
        return $this->entityManager->getRepository(Recipe::class)->findBy(
            [],
            [$orderBy => $order],
            $limit,
            $offset
        );
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
