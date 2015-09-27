<?php

namespace Barra\RestBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractRest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
abstract class AbstractRestController extends FOSRestController implements ClassResourceInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    /** string */
    protected $entityClass;


    /** @return \Symfony\Component\Form\Form */
    abstract public function newAction();


    /**
     * @param Request                           $request
     * @param int                               $successCode
     * @param null|\Barra\AdminBundle\Entity\   $entity
     * @return \FOS\RestBundle\View\View
     */
    abstract protected function processForm(Request $request, $successCode, $entity = null);


    /**
     * List all entries
     * @Annotations\View()
     * @Annotations\QueryParam(
     *      name            = "recipe",
     *      requirements    = "\d+",
     *      description     = "Recipe to get entries from."
     * )
     * @Annotations\QueryParam(
     *      name            = "offset",
     *      requirements    = "\d+",
     *      default         = "0",
     *      description     = "Offset to start from."
     * )
     * @Annotations\QueryParam(
     *      name            = "limit",
     *      requirements    = "\d+",
     *      default         = "4",
     *      description     = "How many entries to return."
     * )
     * @Annotations\QueryParam(
     *      name            = "order_by",
     *      requirements    = "\w+",
     *      default         = "id",
     *      description     = "Column to order by."
     * )
     * @Annotations\QueryParam(
     *      name            = "order",
     *      requirements    = "\w+",
     *      default         = "ASC",
     *      description     = "Order, either ASC or DESC."
     * )
     * @param ParamFetcher $paramFetcher
     * @return array
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $recipe     = $paramFetcher->get('recipe');
        $offset     = $paramFetcher->get('offset');
        $limit      = $paramFetcher->get('limit');
        $orderBy    = $paramFetcher->get('order_by');
        $order      = $paramFetcher->get('order');
        $repo       = $this->getRepo();


        if (null === $recipe) {
            $entities = $repo->getSome($offset, $limit, $orderBy, $order);
        } else {
            $entities = $repo->getSome($recipe, $offset, $limit, $orderBy, $order);
        }

        return ['data' => $entities];
    }


    /**
     * @Annotations\View()
     * @param int $id
     * @return array
     */
    public function getAction($id)
    {
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return ['data' => $entity];
    }


    /**
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function postAction(Request $request)
    {
        return $this->processForm($request, Codes::HTTP_CREATED);
    }


    /**
     * @param Request   $request
     * @param int       $id
     * @return \FOS\RestBundle\View\View
     */
    public function putAction(Request $request, $id)
    {
        /** @var \Barra\AdminBundle\Entity\ $entity */
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            $route = 'barra_api_post_'.lcfirst($this->getEntityClass());
            return $this->routeRedirectView($route, ['request' => $request]);
        }

        return $this->processForm($request, Codes::HTTP_NO_CONTENT, $entity);
    }


    /**
     * @Annotations\View()
     * @param int $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteAction($id)
    {
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        if (!$entity->isRemovable()) {
            return $this->view(null, Codes::HTTP_CONFLICT);
        }

        $this->getEM()->remove($entity);
        $this->getEM()->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
    }






    protected function persistEntity(Request $request, $entity, $successCode)
    {
        $this->getEM()->persist($entity);
        $this->getEM()->flush();

        $params = [
            'id'      => $entity->getId(),
            '_format' => $request->get('_format'),
        ];
        $route = 'barra_api_get_'.lcfirst($this->getEntityClass());


        return $this->routeRedirectView($route, $params, $successCode);
    }


    /**
     * @param string $entityClass
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepo($entityClass = null)
    {
        if (null === $entityClass) {
            $entityClass = $this->getEntityClass();
        }

        return $this->getEM()->getRepository('BarraAdminBundle:'.ucfirst($entityClass));
    }


    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function getEM()
    {
        if (null === $this->em) {
            $this->em = $this->getDoctrine()->getManager();
        }

        return $this->em;
    }


    /**
     * @return string supposed model name based on controller class
     */
    protected function getEntityClass()
    {
        if (null === $this->entityClass) {
            $this->entityClass = ucfirst(
                substr(
                    get_class($this),
                    strrpos(get_class($this), '\\')+1,
                    -10
                )
            );
        }

        return $this->entityClass;
    }
}
