<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Photo;
use AppBundle\Form\PhotoType;
use AppBundle\Repository\PhotoRepository;
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
class PhotoController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @var PhotoRepository
     */
    private $photoRepository;

    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    public function newAction(int $recipeId): View
    {
        return $this->view($this->createForm(PhotoType::class));
    }

    public function cgetAction(int $recipeId): View
    {
        $photos = $this->photoRepository->getPhotos($recipeId);

        return $this->view($photos);
    }

    public function getAction(int $recipeId, int $id): View
    {
        $product = $this->photoRepository->getPhoto($recipeId, $id);

        return null === $product
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($product);
    }

    public function postAction(Request $request, int $recipeId): View
    {
        $recipe = $this->get(RecipeRepository::class)->getRecipe($recipeId);
        if (null === $recipe) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $photo = new Photo($recipeId);
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $photo = $this->photoRepository->addPhoto($photo);

        return $this->routeRedirectView(
            'api_get_recipe_photo',
            ['recipeId' => $recipeId, 'id' => $photo->id],
            Response::HTTP_CREATED
        );
    }

    public function putAction(Request $request, int $recipeId, int $id): View
    {
        $photo = $this->photoRepository->getPhoto($recipeId, $id);

        if (null === $photo) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PhotoType::class, $photo, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $this->photoRepository->setPhoto($photo);

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteAction(int $recipeId, int $id): View
    {
        $photo = $this->photoRepository->getPhoto($recipeId, $id);

        if (null === $photo) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        try {
            $this->photoRepository->deletePhoto($photo);
        } catch (ForeignKeyConstraintViolationException $ex) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
