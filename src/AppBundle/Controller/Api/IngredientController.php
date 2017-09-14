<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Ingredient;
use AppBundle\Form\IngredientType;
use AppBundle\Repository\IngredientRepository;
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
class IngredientController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var IngredientRepository
     */
    private $ingredientRepository;

    public function __construct(IngredientRepository $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    public function newAction(int $recipeId): View
    {
        return $this->view($this->createForm(IngredientType::class));
    }

    public function getProductAction(int $recipeId, int $id): View
    {
        $ingredient = $this->ingredientRepository->getIngredient($recipeId, $id);

        return null === $ingredient
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($ingredient->product);
    }

    public function getMeasurementAction(int $recipeId, int $id): View
    {
        $ingredient = $this->ingredientRepository->getIngredient($recipeId, $id);

        return null === $ingredient
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($ingredient->measurement);
    }

    public function cgetAction(int $recipeId): View
    {
        $ingredients = $this->ingredientRepository->getIngredients($recipeId);

        return $this->view($ingredients);
    }

    public function getAction(int $recipeId, int $id): View
    {
        $ingredient = $this->ingredientRepository->getIngredient($recipeId, $id);

        return null === $ingredient
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($ingredient);
    }

    public function postAction(Request $request, int $recipeId): View
    {
        $recipe = $this->get(RecipeRepository::class)->getRecipe($recipeId);
        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $ingredient = new Ingredient($recipeId);
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $ingredient = $this->ingredientRepository->addIngredient($ingredient);

        return $this->routeRedirectView('api_get_recipe_ingredient', [
            'recipeId' => $recipeId,
            'id' => $ingredient->id,
        ]);
    }

    public function putAction(Request $request, int $recipeId, int $id): View
    {
        $ingredient = $this->ingredientRepository->getIngredient($recipeId, $id);

        if (null === $ingredient) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(IngredientType::class, $ingredient, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->ingredientRepository->setIngredient($ingredient);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteAction(int $recipeId, int $id): View
    {
        $ingredient = $this->ingredientRepository->getIngredient($recipeId, $id);

        if (null === $ingredient) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->ingredientRepository->deleteIngredient($ingredient);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
