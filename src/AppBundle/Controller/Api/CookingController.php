<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Cooking;
use AppBundle\Form\CookingType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\View\View;
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
        $cookings = $this->get('app.repository.cooking')->getCookings($recipeId);

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
        $cooking = $this->get('app.repository.cooking')->getCooking($recipeId, $id);

        return null === $cooking
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($cooking);
    }

    /**
     * @param Request $request
     * @param int $recipeId
     *
     * @return View
     */
    public function postAction(Request $request, $recipeId)
    {
        $recipe = $this->get('app.repository.recipe')->getRecipe($recipeId);
        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $position = $this->get('app.repository.cooking')->getPosition($recipeId);
        $cooking = new Cooking($recipeId, $position);
        $form = $this->createForm(CookingType::class, $cooking);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $cooking = $this->get('app.repository.cooking')->addCooking($cooking);

        return $this->routeRedirectView('api_get_recipe_cooking', [
            'recipeId' => $recipeId,
            'id' => $cooking->getId(),
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
        $cooking = $this->get('app.repository.cooking')->getCooking($recipeId, $id);

        if (null === $cooking) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(CookingType::class, $cooking, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.repository.cooking')->setCooking($cooking);

        return $this->routeRedirectView(
            'api_get_recipe_cooking',
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
        $cooking = $this->get('app.repository.cooking')->getCooking($recipeId, $id);

        if (null === $cooking) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->get('app.repository.cooking')->deleteCooking($cooking);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
