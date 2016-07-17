<?php

namespace AppBundle\Controller\Api;

use AppBundle\Form\RecipeType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return View
     */
    public function newAction()
    {
        return $this->view($this->createForm(RecipeType::class));
    }

    /**
     * @QueryParam(name="offset", requirements="\d+", default="0")
     * @QueryParam(name="limit", requirements="[1-9]\d*", default="10")
     * @QueryParam(name="orderBy", requirements="\w+", default="id")
     * @QueryParam(name="order", requirements="(asc|desc)", default="asc")
     *
     * @param string $offset
     * @param string $limit
     * @param string $orderBy
     * @param string $order
     *
     * @return View
     */
    public function cgetAction($offset, $limit, $orderBy, $order)
    {
        $recipes = $this->get('app.recipe')->getRecipes($orderBy, $order, $limit, $offset);

        return $this->view($recipes);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getAction($id)
    {
        $recipe = $this->get('app.recipe')->getRecipe($id);

        return null === $recipe
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($recipe);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request)
    {
        $form = $this->createForm(RecipeType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $recipe = $this->get('app.recipe')->addRecipe($form->getData());

        return $this->view()->createRouteRedirect('api_get_recipe', ['id' => $recipe->getId()], Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        $recipe = $this->get('app.product')->getProduct($id);

        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(RecipeType::class, $recipe, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.recipe')->setRecipe($recipe);

        return $this->view()->createRouteRedirect('api_get_recipe', ['id' => $id], Response::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function deleteAction($id)
    {
        $recipe = $this->get('app.recipe')->getRecipe($id);

        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->get('app.recipe')->deleteRecipe($recipe);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
