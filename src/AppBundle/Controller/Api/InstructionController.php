<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Instruction;
use AppBundle\Form\InstructionType;
use AppBundle\Repository\InstructionRepository;
use AppBundle\Repository\RecipeRepository;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("is_authenticated()")
 */
class InstructionController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var InstructionRepository
     */
    private $instructionRepository;

    public function __construct(InstructionRepository $instructionRepository)
    {
        $this->instructionRepository = $instructionRepository;
    }

    public function newAction(int $recipeId): View
    {
        return $this->view($this->createForm(InstructionType::class));
    }

    public function cgetAction(int $recipeId): View
    {
        $instructions = $this->instructionRepository->getInstructions($recipeId);

        return $this->view($instructions);
    }

    public function getAction(int $recipeId, int $id): View
    {
        $instruction = $this->instructionRepository->getInstruction($recipeId, $id);

        return null === $instruction
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($instruction);
    }

    public function postAction(Request $request, int $recipeId): View
    {
        $recipe = $this->get(RecipeRepository::class)->getRecipe($recipeId);
        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $position = $this->instructionRepository->getPosition($recipeId);
        $instruction = new Instruction($recipeId, $position);
        $form = $this->createForm(InstructionType::class, $instruction);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $instruction = $this->instructionRepository->addInstruction($instruction);

        return $this->routeRedirectView('api_get_recipe_instruction', ['recipeId' => $recipeId, 'id' => $instruction->id]);
    }

    public function putAction(Request $request, int $recipeId, $id): View
    {
        $instruction = $this->instructionRepository->getInstruction($recipeId, $id);

        if (null === $instruction) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(InstructionType::class, $instruction, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->instructionRepository->setInstruction($instruction);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteAction(int $recipeId, int $id): View
    {
        $instruction = $this->instructionRepository->getInstruction($recipeId, $id);

        if (null === $instruction) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->instructionRepository->deleteInstruction($instruction);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
