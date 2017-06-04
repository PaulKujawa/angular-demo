<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Photo;
use AppBundle\Form\PhotoType;
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
class PhotoController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function newAction(int $recipeId): View
    {
        return $this->view($this->createForm(PhotoType::class));
    }

    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function cgetAction(int $recipeId): View
    {
        $photos = $this->get('app.repository.photo')->getPhotos($recipeId);

        return $this->view($photos);
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getAction(int $recipeId, int $id): View
    {
        $product = $this->get('app.repository.photo')->getPhoto($recipeId, $id);

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
    public function postAction(Request $request, int $recipeId): View
    {
        $recipe = $this->get('app.repository.recipe')->getRecipe($recipeId);
        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $photo = new Photo($recipeId);
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $photo = $this->get('app.repository.photo')->addPhoto($photo);

        return $this->routeRedirectView(
            'api_get_recipe_photo',
            ['recipeId' => $recipeId, 'id' => $photo->id],
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
    public function putAction(Request $request, int $recipeId, int $id): View
    {
        $photo = $this->get('app.repository.photo')->getPhoto($recipeId, $id);

        if (null === $photo) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PhotoType::class, $photo, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->get('app.repository.photo')->setPhoto($photo);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function deleteAction(int $recipeId, int $id): View
    {
        $photo = $this->get('app.repository.photo')->getPhoto($recipeId, $id);

        if (null === $photo) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->get('app.repository.photo')->deletePhoto($photo);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
