<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Photo;
use Barra\RecipeBundle\Entity\Recipe;
use Barra\RecipeBundle\Form\PhotoType;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

class PhotoController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function newAction($recipeId)
    {
        return $this->view(['data' => $this->createForm(PhotoType::class)]);
    }

    /**
     * @param int $recipeId
     *
     * @return View
     */
    public function cgetAction($recipeId)
    {
        $photos = $this->getDoctrine()->getManager()->getRepository(Photo::class)->findBy(['recipe' => $recipeId]);

        return $this->view(['data' => $photos]);
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return View
     */
    public function getAction($recipeId, $id)
    {
        $photo = $this->getDoctrine()->getManager()->getRepository(Photo::class)->find($id);

        return null === $photo || (int) $recipeId !== $photo->getRecipe()->getId()
            ? $this->view(null, Codes::HTTP_NOT_FOUND)
            : $this->view(['data' => $photo]);
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
            return $this->view(['data' => $this->createForm(PhotoType::class)], Codes::HTTP_BAD_REQUEST);
        }

        $photo = new Photo();
        $photo->setRecipe($recipe);

        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
        }

        $em->persist($photo);
        $em->flush();

        return $this->routeRedirectView('barra_api_get_recipe_photo', [
            'recipeId' => $recipeId,
            'id' => $photo->getId(),
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
        $photo = $em->getRepository(Photo::class)->find($id);

        if (!$photo instanceof Photo || (int) $recipeId !== $photo->getRecipe()->getId()) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PhotoType::class, $photo, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
        }
        $em->flush();

        return $this->routeRedirectView(
            'barra_api_get_recipe_photo',
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
        $photo = $this->getDoctrine()->getManager()->getRepository(Photo::class)->find($id);

        if (null === $photo || (int) $recipeId !== $photo->getRecipe()->getId()) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        if (!$photo->isRemovable()) {
            return $this->view(null, Codes::HTTP_CONFLICT);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($photo);
        $em->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }
}
