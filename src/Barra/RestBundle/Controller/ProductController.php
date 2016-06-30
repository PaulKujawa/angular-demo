<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Product;
use Barra\RecipeBundle\Form\ProductType;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends FOSRestController implements ClassResourceInterface
{
    /**
     * @return View
     */
    public function newAction()
    {
        return $this->view($this->createForm(ProductType::class));
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
        $products = $this->getDoctrine()->getManager()->getRepository(Product::class)->findBy(
            [],
            [$orderBy => $order],
            $limit,
            $offset
        );

        // alternatively, 'limit' could be set as strict in it's annotation to set it mandatory.
        return (null === $limit || $limit < 1 || $offset < 0)
            ? $this->view(null, Response::HTTP_BAD_REQUEST)
            : $this->view($products);
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getIngredientsAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository(Product::class)->find($id);

        return null === $entity
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($entity->getIngredients());
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getManufacturerAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository(Product::class)->find($id);

        return null === $entity
            ? $this->view(null, Response::HTTP_NOT_FOUND)
            : $this->view($entity->getManufacturer());
    }

    /**
     * @param int $id
     *
     * @return View
     */
    public function getAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository(Product::class)->find($id);

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
        $entity = new Product();
        $form = $this->createForm(ProductType::class, $entity);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($entity);
        $em->flush();

        return $this->routeRedirectView('barra_api_get_product', [
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
        $entity = $em->getRepository(Product::class)->find($id);

        if (null === $entity) {
            return $this->view(null, Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(ProductType::class, $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->view($form, Response::HTTP_BAD_REQUEST);
        }
        $em->flush();

        return $this->routeRedirectView(
            'barra_api_get_product',
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
        $entity = $this->getDoctrine()->getManager()->getRepository(Product::class)->find($id);

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
