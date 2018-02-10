<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Instruction;
use Doctrine\ORM\EntityManager;

class InstructionRepository
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
        return $this->entityManager->getRepository(Instruction::class)->getNextPosition($recipeId);
    }

    /**
     * @return Instruction[]|array
     */
    public function getInstructions(int $recipeId): array
    {
        return $this->entityManager->getRepository(Instruction::class)->findBy(
            ['recipe' => $recipeId],
            ['position' => 'ASC']
        );
    }

    public function getInstruction(int $recipeId, int $id): ?Instruction
    {
        return $this->entityManager->getRepository(Instruction::class)->findOneBy(['id' => $id, 'recipe' => $recipeId]);
    }

    public function addInstruction(Instruction $instruction): Instruction
    {
        $this->entityManager->persist($instruction);
        $this->entityManager->flush($instruction);

        return $instruction;
    }

    public function setInstruction(Instruction $instruction): void
    {
        $this->entityManager->flush($instruction);
    }

    public function deleteInstruction(Instruction $instruction): int
    {
        $this->entityManager->remove($instruction);
        $this->entityManager->flush($instruction);
    }
}
