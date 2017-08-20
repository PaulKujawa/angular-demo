<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Ingredient;
use Doctrine\ORM\EntityManager;

class IngredientRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $recipeId
     *
     * @return Ingredient[]|array
     */
    public function getIngredients(int $recipeId): array
    {
        return $this->entityManager->getRepository(Ingredient::class)->findBy(['recipe' => $recipeId]);
    }

    public function getIngredient(int $recipeId, int $id): ?Ingredient
    {
        return $this->entityManager->getRepository(Ingredient::class)->findOneBy(['id' => $id, 'recipe' => $recipeId]);
    }

    public function addIngredient(Ingredient $ingredient): Ingredient
    {
        $this->entityManager->persist($ingredient);
        $this->entityManager->flush($ingredient);

        return $ingredient;
    }

    public function setIngredient(Ingredient $ingredient): void
    {
        $this->entityManager->flush($ingredient);
    }

    public function deleteIngredient(Ingredient $ingredient): void
    {
        $this->entityManager->remove($ingredient);
        $this->entityManager->flush($ingredient);
    }
}
