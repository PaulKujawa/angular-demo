<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Repository\BasicRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RestController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class RestController extends FOSRestController implements ClassResourceInterface
{
    /** @var EntityManager */
    protected $em;

    /** @var string */
    protected $entityClass;

    /** @var  AbstractType */
    protected $formType;

    /** @var  mixed */
    protected $entity;

    /**
     * @return View
     */
    public function newAction()
    {
        $form = $this->createForm($this->getFormType(), $this->getEntity());

        return $this->view(['data' => $form]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function getAction($id)
    {
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->view(['data' => $entity]);
    }

    /**
     * @link http://symfony.com/doc/current/bundles/FOSRestBundle/param_fetcher_listener.html
     *
     * @Annotations\QueryParam(
     *      name            = "offset",
     *      requirements    = "\d+",
     *      default         = "0",
     *      description     = "Offset to start from."
     * )
     * @Annotations\QueryParam(
     *      name            = "limit",
     *      requirements    = "\d+",
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
     *      requirements    = "(asc|desc)",
     *      default         = "asc",
     *      description     = "Sort direction."
     * )
     *
     * @param ParamFetcher $paramFetcher
     * @return array
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $offset     = $paramFetcher->get('offset');
        $limit      = $paramFetcher->get('limit');
        $orderBy    = $paramFetcher->get('order_by');
        $order      = $paramFetcher->get('order');

        // alternatively, 'limit' could be set as strict, in it's annotation, to set it mandatory.
        // however, RestBundle's own error message is too detailed IMHO.
        if (null === $limit ||
            1 > $limit ||
            0 > $offset
        ) {
            return $this->view(null, Codes::HTTP_BAD_REQUEST);
        }
        $entities = $this->getRepo()->getSome($offset, $limit, $orderBy, $order);

        return $this->view(['data' => $entities]);
    }

    /**
     * @return View
     */
    public function countAction()
    {
        $count = $this->getRepo()->count();

        return $this->view(['data' => $count]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $entity = $this->getEntity();

        return $this->processRequest($request, $entity, Codes::HTTP_CREATED);
    }

    /**
     * @param Request   $request
     * @param int       $id
     * @return View
     */
    public function putAction(Request $request, $id)
    {
        $entity = $this->getRepo()->find($id);

        if (null === $entity) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->processRequest($request, $entity, Codes::HTTP_NO_CONTENT);
    }

    /**
     * @param int $id
     * @return View
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



    // ######### HELPER #########################################

    /**
     * So far for POST and PUT requests
     * @param Request       $request
     * @param object        $entity
     * @param int           $successCode
     * @return View
     */
    protected function processRequest(Request $request, $entity, $successCode)
    {
        $form = $this->createForm($this->getFormType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
        }

        if ($request->isMethod('POST')) {
            $this->getEM()->persist($entity);
        }
        $this->getEM()->flush();

        $route  = 'barra_api_get_'.lcfirst($this->getEntityClass());
        $params = [
            'id'      => $entity->getId(),
            '_format' => $request->get('_format'),
        ];

        return $this->routeRedirectView($route, $params, $successCode);
    }

    /**
     * @return string upper cased semantic name of inheriting controller
     */
    protected function getEntityClass()
    {
        if (null === $this->entityClass) {
	    // __CLASS_ returns RestController, get_class($this) inheriting class
            $className = get_class($this);
            $this->entityClass = ucfirst(
                substr(
                    $className,
                    strrpos($className, '\\') + 1,
                    -10
                )
            );
        }

        return $this->entityClass;
    }

    /**
     * @return AbstractType
     */
    protected function getFormType()
    {
        if (null === $this->formType) {
            $namespace      = '\Barra\RecipeBundle\Form\\';
            $form           = $namespace.$this->getEntityClass().'Type';
            $this->formType = new $form();
        }

        return $this->formType;
    }

    /**
     * @return mixed entity
     */
    protected function getEntity()
    {
        if (null === $this->entity) {
            $namespace      = '\Barra\RecipeBundle\Entity\\';
            $entity         = $namespace.$this->getEntityClass();
            $this->entity   = new $entity();
        }

        return $this->entity;
    }

    /**
     * @param string $entityClass
     * @return BasicRepository
     */
    protected function getRepo($entityClass = null)
    {
        if (null === $entityClass) {
            $entityClass = $this->getEntityClass();
        }

        return $this->getEM()->getRepository('BarraRecipeBundle:'.ucfirst($entityClass));
    }

    /**
     * @return EntityManager
     */
    protected function getEM()
    {
        if (null === $this->em) {
            $this->em = $this->getDoctrine()->getManager();
        }

        return $this->em;
    }
}
