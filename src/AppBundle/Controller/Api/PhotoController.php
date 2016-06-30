<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Photo;
use AppBundle\Entity\Recipe;
use AppBundle\Form\PhotoType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param int $recipeId
     *
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
        $photos = $this->getDoctrine()->getManager()->getRepository(Photo::class)->findBy(['recipe' => $recipeId]);

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
        $photos = $this->getDoctrine()->getManager()->getRepository(Photo::class)->findBy([
            'id' => $id,
            'recipe' => $recipeId,
        ]);

        return empty($photos)
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($photos[0]);
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
            return $this->view($this->createForm(PhotoType::class), Response::HTTP_BAD_REQUEST);
        }

        $photo = new Photo();
        $photo->setRecipe($recipe);

        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $em->persist($photo);
        $em->flush();

        return $this->routeRedirectView('api_get_recipe_photo', [
            'recipeId' => $recipeId,
            'id' => $photo->getId(),
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
        $photos = $em->getRepository(Photo::class)->findBy([
            'id' => $id,
            'recipe' => $recipeId,
        ]);

        if (empty($photos)) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PhotoType::class, $photos[0], ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }
        $em->flush();

        return $this->routeRedirectView(
            'api_get_recipe_photo',
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
        $photo = $this->getDoctrine()->getManager()->getRepository(Photo::class)->find($id);

        if (null === $photo || (int) $recipeId !== $photo->getRecipe()->getId()) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        if (!$photo->isRemovable()) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($photo);
        $em->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
