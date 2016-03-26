<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Measurement;
use Barra\RecipeBundle\Entity\Repository\BasicRepository;
use Barra\RecipeBundle\Entity\Repository\RecipeRelatedRepository;
use Barra\RecipeBundle\Form\MeasurementType;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

class MeasurementController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return View
     */
    public function newAction()
    {
        return $this->view(['data' => $this->createForm(MeasurementType::class)]);
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
     * @return array
     */
    public function cgetAction($offset, $limit, $orderBy, $order)
    {
        /** @var BasicRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository(Measurement::class);

        // alternatively, 'limit' could be set as strict in it's annotation to set it mandatory.
        return (null === $limit || $limit < 1 || $offset < 0)
            ? $this->view(null, Codes::HTTP_BAD_REQUEST)
            : $this->view(['data' => $repo->getSome($offset, $limit, $orderBy, $order)]);
    }

    /**
     * @return View
     */
    public function countAction()
    {
        /** @var RecipeRelatedRepository $repo */
        $repo = $this->getDoctrine()->getManager()->getRepository(Measurement::class);

        return $this->view(['data' => $repo->count()]);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getIngredientsAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository(Measurement::class)->find($id);

        return null === $entity
            ? $this->view(null, Codes::HTTP_NOT_FOUND)
            : $this->view(['data' => $entity->getIngredients()]);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository(Measurement::class)->find($id);

        return null === $entity
            ? $this->view(null, Codes::HTTP_NOT_FOUND)
            : $this->view(['data' => $entity]);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getRecipeAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository(Measurement::class)->find($id);

        return null === $entity
            ? $this->view(null, Codes::HTTP_NOT_FOUND)
            : $this->view(['data' => $entity->getRecipe()]);
    }

    /**
     * @param Request $request
     *
     * @return View
     */
    public function postAction(Request $request)
    {
        $entity = new Measurement();
        $form = $this->createForm(MeasurementType::class, $entity);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $this->routeRedirectView('barra_api_get_measurement', [
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
        $entity = $em->getRepository(Measurement::class)->find($id);

        if (!$entity instanceof Measurement) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(MeasurementType::class, $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
        }
        $em->flush();

        return $this->routeRedirectView(
            'barra_api_get_measurement',
            [
                'id' => $entity->getId(),
                '_format' => $request->get('_format'),
            ],
            Codes::HTTP_NO_CONTENT
        );
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function deleteAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository(Measurement::class)->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        if (!$entity->isRemovable()) {
            return $this->view(null, Codes::HTTP_CONFLICT);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }
}
