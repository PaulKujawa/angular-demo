<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Cooking;
use Doctrine\ORM\EntityManager;

class CookingRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager= $entityManager;
    }

    public function getPosition(int $recipeId): int {
        return $this->entityManager->getRepository(Cooking::class)->getNextPosition($recipeId);
    }

    /**
     * @return Cooking[]|array
     */
    public function getCookings(int $recipeId): array
    {
        return $this->entityManager->getRepository(Cooking::class)->findBy(
            ['recipe' => $recipeId],
            ['position' => 'ASC']
        );
    }

    public function getCooking(int $recipeId, int $id): ?Cooking
    {
        return $this->entityManager->getRepository(Cooking::class)->findOneBy(['id' => $id, 'recipe' => $recipeId]);
    }

    public function addCooking(Cooking $cooking): Cooking
    {
        $this->entityManager->persist($cooking);
        $this->entityManager->flush($cooking);

        return $cooking;
    }

    public function setCooking(Cooking $cooking): void
    {
        $this->entityManager->flush($cooking);
    }

    public function deleteCooking(Cooking $cooking): int
    {
        $this->entityManager->remove($cooking);
        $this->entityManager->flush($cooking);
    }
}
