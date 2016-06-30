<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Recipe;
use AppBundle\Form\RecipeType;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
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
     * @QueryParam(name="limit", requirements="\d+")
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
        $recipes = $this->getDoctrine()->getManager()->getRepository(Recipe::class)->findBy(
            [],
            [$orderBy => $order],
            $limit,
            $offset
        );

        // alternatively, 'limit' could be set as strict in it's annotation to set it mandatory.
        return (null === $limit || $limit < 1 || $offset < 0)
            ? $this->view(null, Response::HTTP_BAD_REQUEST)
            : $this->view($recipes);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository(Recipe::class)->find($id);

        return null === $entity
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($entity);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request)
    {
        $entity = new Recipe();
        $form = $this->createForm(RecipeType::class, $entity);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $this->routeRedirectView('api_get_recipe', [
            'id' => $entity->getId(),
            '_format' => $request->get('_format'),
        ]);
    }

    /**
     * @param Request $request
     * @param int $id
     *
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Recipe::class)->find($id);

        if (null === $entity) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(RecipeType::class, $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }
        $em->flush();

        return $this->routeRedirectView(
            'api_get_recipe',
            [
                'id' => $entity->getId(),
                '_format' => $request->get('_format'),
            ],
            Response::HTTP_NO_CONTENT
        );
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function deleteAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository(Recipe::class)->find($id);

        if (null === $entity) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        if (!$entity->isRemovable()) {
            return $this->view(null, Response::HTTP_CONFLICT);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        return $this->view(null, Response::HTTP_NO_CONTENT);
    }
}
