<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Cooking;
use AppBundle\Entity\Recipe;
use AppBundle\Form\CookingType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CookingController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function newAction($recipeId)
    {
        return $this->view($this->createForm(CookingType::class));
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

        return $this->view($cookings);
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getAction($recipeId, $id)
    {
        $cookings = $this->getDoctrine()->getManager()->getRepository(Cooking::class)->findBy([
            'id' => $id,
            'recipe' => $recipeId,
        ]);

        return empty($cookings)
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($cookings[0]);
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
            return $this->view($this->createForm(CookingType::class), Response::HTTP_BAD_REQUEST);
        }

        $repo = $em->getRepository(Cooking::class);
        $cooking = new Cooking();
        $cooking->setPosition($repo->getNextPosition($recipe->getId()));
        $cooking->setRecipe($recipe);

        $form = $this->createForm(CookingType::class, $cooking);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($cooking);
        $em->flush();

        return $this->routeRedirectView('api_get_recipe_cooking', [
            'recipeId' => $recipeId,
            'id' => $cooking->getId(),
            '_format' => $request->get('_format'),
        ]);
    }

    /**
     * @param Request $request
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function putAction(Request $request, $recipeId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $cookings = $em->getRepository(Cooking::class)->findBy([
            'id' => $id,
            'recipe' => $recipeId,
        ]);

        if (empty($cookings)) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(CookingType::class, $cookings[0], ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }
        $em->flush();

        return $this->routeRedirectView(
            'api_get_recipe_cooking',
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
        $cooking = $this->getDoctrine()->getManager()->getRepository(Cooking::class)->find($id);

        if (null === $cooking || (int) $recipeId !== $cooking->getRecipe()->getId()) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        if (!$cooking->isRemovable()) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($cooking);
        $em->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
