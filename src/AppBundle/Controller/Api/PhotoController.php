<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Photo;
use AppBundle\Form\PhotoType;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return View
     */
    public function newAction($recipeId)
    {
        return $this->view($this->createForm(PhotoType::class));
    }

    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function cgetAction($recipeId)
    {
        $photos = $this->get('app.photo')->getPhotos($recipeId);

        return $this->view($photos);
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getAction($recipeId, $id)
    {
        $product = $this->get('app.photo')->getPhoto($recipeId, $id);

        return null === $product
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($product);
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

        $photo = new Photo($recipeId);
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $photo = $this->get('app.photo')->addPhoto($photo);

        return $this->view()->createRouteRedirect(
            'api_get_recipe_photo',
            ['recipeId' => $recipeId, 'id' => $photo->getId()],
            Response::HTTP_CREATED
        );
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
        $photo = $this->get('app.photo')->getPhoto($recipeId, $id);

        if (null === $photo) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PhotoType::class, $photo, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.photo')->setPhoto($photo);

        return $this->view()->createRouteRedirect(
            'api_get_recipe_photo',
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
        $photo = $this->get('app.photo')->getPhoto($recipeId, $id);

        if (null === $photo) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->get('app.photo')->deletePhoto($photo);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
