<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Ingredient;
use Barra\RecipeBundle\Entity\Recipe;
use Barra\RecipeBundle\Form\IngredientType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredientController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getProductAction($recipeId, $id)
    {
        $ingredients = $this->getDoctrine()->getManager()->getRepository(Ingredient::class)->findBy([
            'id' => $id,
            'recipe' => $recipeId,
        ]);

        return empty($ingredients)
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($ingredients[0]->getProduct());
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getMeasurementAction($recipeId, $id)
    {
        $ingredient = $this->getDoctrine()->getManager()->getRepository(Ingredient::class)->find($id);

        return null === $ingredient || (int) $recipeId !== $ingredient->getRecipe()->getId()
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($ingredient->getMeasurement());
    }

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
     *
     * @return View
     */
    public function cgetAction($recipeId)
    {
        $ingredients = $this->getDoctrine()->getManager()->getRepository(Ingredient::class)->findBy(
            ['recipe' => $recipeId],
            ['position' => 'ASC']
        );

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
        $ingredients = $this->getDoctrine()->getManager()->getRepository(Ingredient::class)->findBy([
            'id' => $id,
            'recipe' => $recipeId,
        ]);

        return empty($ingredients)
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($ingredients[0]);
    }

    /**
     * @param Request $request
     * @param int $recipeId
     *
     * @return View
     */
    public function postAction(Request $request, $recipeId)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository(Recipe::class)->find($recipeId);
        if (null === $recipe) {
            return $this->view($this->createForm(IngredientType::class), Response::HTTP_BAD_REQUEST);
        }

        $repo = $em->getRepository(Ingredient::class);
        $ingredient = new Ingredient();
        $ingredient->setPosition($repo->getNextPosition($recipeId));
        $ingredient->setRecipe($recipe);

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($ingredient);
        $em->flush();

        return $this->routeRedirectView('barra_api_get_recipe_ingredient', [
            'recipeId' => $recipeId,
            'id' => $ingredient->getId(),
            '_format' => $request->get('_format'),
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
        $em = $this->getDoctrine()->getManager();
        $ingredients = $em->getRepository(Ingredient::class)->findBy([
            'id' => $id,
            'recipe' => $recipeId,
        ]);

        if (empty($ingredients)) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(IngredientType::class, $ingredients[0], ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }
        $em->flush();

        return $this->routeRedirectView(
            'barra_api_get_recipe_ingredient',
            [
                'recipeId' => $recipeId,
                'id' => $id,
                '_format' => $request->get('_format'),
            ],
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
        $ingredients = $this->getDoctrine()->getManager()->getRepository(Ingredient::class)->findBy([
            'id' => $id,
            'recipe' => $recipeId,
        ]);

        if (empty($ingredients)) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        if (!$ingredients[0]->isRemovable()) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($ingredients[0]);
        $em->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
