<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Ingredient;
use Barra\RecipeBundle\Entity\Recipe;
use Barra\RecipeBundle\Form\IngredientType;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

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
        $product = $this->getDoctrine()->getManager()->getRepository(Ingredient::class)->find($id);

        return null === $product || (int) $recipeId !== $product->getRecipe()->getId()
            ? $this->view(null, Codes::HTTP_NOT_FOUND)
            : $this->view(['data' => $product->getProduct()]);
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
            ? $this->view(null, Codes::HTTP_NOT_FOUND)
            : $this->view(['data' => $ingredient->getMeasurement()]);
    }

    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function newAction($recipeId)
    {
        return $this->view(['data' => $this->createForm(IngredientType::class)]);
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

        return $this->view(['data' => $ingredients]);
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getAction($recipeId, $id)
    {
        $ingredient = $this->getDoctrine()->getManager()->getRepository(Ingredient::class)->find($id);

        return null === $ingredient || (int) $recipeId !== $ingredient->getRecipe()->getId()
            ? $this->view(null, Codes::HTTP_NOT_FOUND)
            : $this->view(['data' => $ingredient]);
    }

    /**
     * @param int $recipeId
     * @param Request $request
     *
     * @return View
     */
    public function postAction($recipeId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository(Recipe::class)->find($recipeId);
        if (!$recipe instanceof Recipe) {
            return $this->view(['data' => $this->createForm(IngredientType::class)], Codes::HTTP_BAD_REQUEST);
        }

        $repo = $em->getRepository(Ingredient::class);
        $ingredient = new Ingredient();
        $ingredient->setPosition($repo->getNextPosition($recipe->getId()));
        $ingredient->setRecipe($recipe);

        $form = $this->createForm(IngredientType::class, $ingredient);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
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
        $ingredient = $em->getRepository(Ingredient::class)->find($id);

        if (!$ingredient instanceof Ingredient || (int) $recipeId !== $ingredient->getRecipe()->getId()) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(IngredientType::class, $ingredient, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
        }
        $em->flush();

        return $this->routeRedirectView(
            'barra_api_get_recipe_ingredient',
            [
                'recipeId' => $recipeId,
                'id' => $id,
                '_format' => $request->get('_format'),
            ],
            Codes::HTTP_NO_CONTENT
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
        $ingredient = $this->getDoctrine()->getManager()->getRepository(Ingredient::class)->find($id);

        if (null === $ingredient || (int) $recipeId !== $ingredient->getRecipe()->getId()) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        if (!$ingredient->isRemovable()) {
            return $this->view(null, Codes::HTTP_CONFLICT);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($ingredient);
        $em->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }
}
