<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Cooking;
use Barra\RecipeBundle\Entity\Recipe;
use Barra\RecipeBundle\Form\CookingType;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

class CookingController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function newAction($recipeId)
    {
        return $this->view(['data' => $this->createForm(CookingType::class)]);
    }

    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function cgetAction($recipeId)
    {
        $cookings = $this->getDoctrine()->getManager()->getRepository(Cooking::class)->findBy(
            ['recipe' => $recipeId],
            ['position' => 'ASC']
        );

        return $this->view(['data' => $cookings]);
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getAction($recipeId, $id)
    {
        $cooking = $this->getDoctrine()->getManager()->getRepository(Cooking::class)->find($id);

        return null === $cooking || (int) $recipeId !== $cooking->getRecipe()->getId()
            ? $this->view(null, Codes::HTTP_NOT_FOUND)
            : $this->view(['data' => $cooking]);
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
            return $this->view(['data' => $this->createForm(CookingType::class)], Codes::HTTP_BAD_REQUEST);
        }

        $repo = $em->getRepository(Cooking::class);
        $cooking = new Cooking();
        $cooking->setPosition($repo->getNextPosition($recipe->getId()));
        $cooking->setRecipe($recipe);

        $form = $this->createForm(CookingType::class, $cooking);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
        }

        $em->persist($cooking);
        $em->flush();

        return $this->routeRedirectView('barra_api_get_recipe_cooking', [
            'recipeId' => $recipeId,
            'id' => $cooking->getId(),
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
        $cooking = $em->getRepository(Cooking::class)->find($id);

        if (!$cooking instanceof Cooking || (int) $recipeId !== $cooking->getRecipe()->getId()) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(CookingType::class, $cooking, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
        }
        $em->flush();

        return $this->routeRedirectView(
            'barra_api_get_recipe_cooking',
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
        $cooking = $this->getDoctrine()->getManager()->getRepository(Cooking::class)->find($id);

        if (null === $cooking || (int) $recipeId !== $cooking->getRecipe()->getId()) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        if (!$cooking->isRemovable()) {
            return $this->view(null, Codes::HTTP_CONFLICT);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($cooking);
        $em->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }
}
