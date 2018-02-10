<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Instruction;
use AppBundle\Entity\Recipe;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;

class LoadInstructionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @var Instruction[]
     */
    static public $members = [];

    public function load(ObjectManager $em): void
    {
        self::$members[] = $this->instantiate(1, '1th step', 'refRecipe1');
        self::$members[] = $this->instantiate(2, '2th step', 'refRecipe1');
        self::$members[] = $this->instantiate(3, '3th step', 'refRecipe1');

        array_walk(self::$members, function(Instruction $member, $i) use ($em) {
            $this->addReference('refInstruction' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();
    }

    private function instantiate(int $position, string $description, string $refRecipe): Instruction
    {
        $recipe = $this->getReference($refRecipe);

        if (!$recipe instanceof Recipe) {
            throw new InvalidArgumentException();
        }

        $instruction = new Instruction($recipe->getId(), $position);
        $instruction->description = $description;

        return $instruction;
    }

    public function getOrder(): int
    {
        return 6;
    }
}
