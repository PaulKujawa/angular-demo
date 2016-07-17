<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Ingredient;
use AppBundle\Form\IngredientType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredientController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function newAction($recipeId)
    {
        return $this->view($this->createForm(IngredientType::class));
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getProductAction($recipeId, $id)
    {
        $ingredient = $this->get('app.ingredient')->getIngredient($recipeId, $id);

        return null === $ingredient
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($ingredient->getProduct());
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getMeasurementAction($recipeId, $id)
    {
        $ingredient = $this->get('app.ingredient')->getIngredient($recipeId, $id);

        return null === $ingredient
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($ingredient->getMeasurement());
    }

    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function cgetAction($recipeId)
    {
        $ingredients = $this->get('app.ingredient')->getIngredients($recipeId);

        return $this->view($ingredients);
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getAction($recipeId, $id)
    {
        $ingredient = $this->get('app.ingredient')->getIngredient($recipeId, $id);

        return null === $ingredient
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($ingredient);
    }

    /**
     * @param Request $request
     * @param int $recipeId
     *
     * @return View
     */
    public function postAction(Request $request, $recipeId)
    {
        $recipe = $this->get('app.recipe')->getRecipe($recipeId);
        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $position = $this->get('app.ingredient')->getPosition($recipeId);
        $ingredient = new Ingredient($recipeId, $position);
        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $ingredient = $this->get('app.ingredient')->addIngredient($ingredient);

        return $this->routeRedirectView('api_get_recipe_ingredient', [
            'recipeId' => $recipeId,
            'id' => $ingredient->getId(),
        ]);
    }

    /**
     * @param int $recipeId
     * @param int $id
     * @param Request $request
     *
     * @return View
     */
    public function putAction($recipeId, $id, Request $request)
    {
        $ingredient = $this->get('app.ingredient')->getIngredient($recipeId, $id);

        if (null === $ingredient) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(IngredientType::class, $ingredient, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.ingredient')->setIngredient($ingredient);

        return $this->routeRedirectView(
            'api_get_recipe_ingredient',
            ['recipeId' => $recipeId, 'id' => $id],
            Response::HTTP_NO_CONTENT
        );
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function deleteAction($recipeId, $id)
    {
        $ingredient = $this->get('app.ingredient')->getIngredient($recipeId, $id);

        if (null === $ingredient) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->get('app.ingredient')->deleteIngredient($ingredient);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
