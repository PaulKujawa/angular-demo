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

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager= $entityManager;
    }

    /**
     * @param int $recipeId
     *
     * @return int
     */
    public function getPosition($recipeId) {
        return $this->entityManager->getRepository(Ingredient::class)->getNextPosition($recipeId);
    }

    /**
     * @param int $recipeId
     *
     * @return Ingredient[]|array
     */
    public function getIngredients($recipeId)
    {
        return $this->entityManager->getRepository(Ingredient::class)->findBy(
            ['recipe' => $recipeId],
            ['position' => 'ASC']
        );
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return Ingredient|null
     */
    public function getIngredient($recipeId, $id)
    {
        return $this->entityManager->getRepository(Ingredient::class)->findOneBy(['id' => $id, 'recipe' => $recipeId]);
    }

    /**
     * @param Ingredient $ingredient
     *
     * @return Ingredient
     */
    public function addIngredient(Ingredient $ingredient)
    {
        $this->entityManager->persist($ingredient);
        $this->entityManager->flush($ingredient);

        return $ingredient;
    }

    /**
     * @param Ingredient $ingredient
     */
    public function setIngredient(Ingredient $ingredient)
    {
        $this->entityManager->flush($ingredient);
    }

    /**
     * @param Ingredient $ingredient
     */
    public function deleteIngredient(Ingredient $ingredient)
    {
        $this->entityManager->remove($ingredient);
        $this->entityManager->flush($ingredient);
    }
}
