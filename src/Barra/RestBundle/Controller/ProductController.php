<?php

namespace Barra\RestBundle\Controller;

use Barra\BackBundle\Form\Type\ProductType;
use Barra\FrontBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ProductController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class ProductController extends FOSRestController
{
    /** @var EntityManager  */
    protected $em;


    /**
     * Returns form
     * @return \Symfony\Component\Form\Form
     */
    public function newProductAction() {
        $form = $this->createForm(new ProductType(), new Product());

        return array('data' => $form);
    }


    /**
     * List all entries
     * @Annotations\View()
     * @Annotations\QueryParam(name="offset",   requirements="\d+", default="0",   description="Offset to start from.")
     * @Annotations\QueryParam(name="limit",    requirements="\d+", default="2",   description="How many entries to return.")
     * @Annotations\QueryParam(name="order_by", requirements="\w+", default="id",  description="Column to order by.")
     * @Annotations\QueryParam(name="order",    requirements="\w+", default="ASC", description="Order, either ASC or DESC.")
     * @param ParamFetcher $paramFetcher
     * @return array
     */
    public function getProductsAction(ParamFetcher $paramFetcher)
    {
        $offset     = (int) $paramFetcher->get('offset');
        $limit      = (int) $paramFetcher->get('limit');
        $orderBy    = $paramFetcher->get('order_by');
        $order      = $paramFetcher->get('order');
        $entities   = $this->getRepo()->getSome($offset, $limit, $orderBy, $order);

        return array('data' => $entities);
    }


    /**
     * Get single entry
     * @Annotations\View()
     * @param int $id
     * @return array
     */
    public function getProductAction($id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Product) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return array('data' => $entity);
    }


    /**
     * Create new entry
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function postProductAction(Request $request)
    {
        $product = new Product();

        return $this->processForm($request, $product, 'POST', Codes::HTTP_CREATED);
    }


    /**
     * Replace or create entry
     * @param Request   $request
     * @param int       $id
     * @return array|\FOS\RestBundle\View\View
     */
    public function putProductAction(Request $request, $id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Product) {
            return $this->routeRedirectView('barra_api_post_product', array('request' => $request));
        }

        return $this->processForm($request, $entity, 'PUT', Codes::HTTP_NO_CONTENT);
    }


    /**
     * Delete one product
     * @Annotations\View()
     * @param int   $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteProductAction($id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Product) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        $dependencies = $this->getRepo('Ingredient')->findByProduct($entity);
        if (!empty($dependencies)) {
            return $this->view(null, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->getEM()->remove($entity);
        $this->getEM()->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }


    /**
     * Actual form handling
     * @param Request   $request
     * @param Product   $entity
     * @param string    $method
     * @param int       $successCode
     * @return \FOS\RestBundle\View\View
     */
    protected function processForm(Request $request, Product $entity, $method, $successCode)
    {
        $form = $this->createForm(new ProductType(), $entity, array('method' => $method));
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        $duplicate = $this->getRepo()->findOneByName($entity->getName());
        if ($duplicate instanceof Product) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->getEM()->persist($entity);
        $this->getEM()->flush();

        $params = array(
            'id'        => $entity->getId(),
            '_format'   => $request->get('_format'),
        );

        return $this->routeRedirectView('barra_api_get_product', $params, $successCode);
    }


    /**
     * @return EntityManager
     */
    protected function getEM()
    {
        if (is_null($this->em)) {
            $this->em = $this->getDoctrine()->getManager();
        }

        return $this->em;
    }


    /**
     * @param string $className
     * @return \Doctrine\Common\Persistence\ObjectRepository|\Doctrine\ORM\EntityRepository
     */
    protected function getRepo($className = 'Product') {
        return $this->getEM()->getRepository('BarraFrontBundle:'.$className);
    }
}