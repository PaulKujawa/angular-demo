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
    public function getPosition($recipeId): int {
        return $this->entityManager->getRepository(Cooking::class)->getNextPosition($recipeId);
    }

    /**
     * @param int $recipeId
     *
     * @return Cooking[]|array
     */
    public function getCookings(int $recipeId): array
    {
        return $this->entityManager->getRepository(Cooking::class)->findBy(
            ['recipe' => $recipeId],
            ['position' => 'ASC']
        );
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return Cooking|null
     */
    public function getCooking($recipeId, int $id)
    {
        return $this->entityManager->getRepository(Cooking::class)->findOneBy(['id' => $id, 'recipe' => $recipeId]);
    }

    /**
     * @param Cooking $cooking
     *
     * @return Cooking
     */
    public function addCooking(Cooking $cooking)
    {
        $this->entityManager->persist($cooking);
        $this->entityManager->flush($cooking);

        return $cooking;
    }

    /**
     * @param Cooking $cooking
     */
    public function setCooking(Cooking $cooking)
    {
        $this->entityManager->flush($cooking);
    }

    /**
     * @param Cooking $cooking
     */
    public function deleteCooking(Cooking $cooking)
    {
        $this->entityManager->remove($cooking);
        $this->entityManager->flush($cooking);
    }
}
