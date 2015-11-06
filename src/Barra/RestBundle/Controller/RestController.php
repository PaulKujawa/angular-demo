<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Entity\Repository\BasicRepository;
use Barra\AdminBundle\Entity\Repository\RecipeRelatedRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RestController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class RestController extends FOSRestController implements ClassResourceInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    /** string */
    protected $entityClass;

    /** @var  \Symfony\Component\Form\AbstractType */
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
     * @param ParamFetcher $paramFetcher
     * @return array
     * @throws \RuntimeException
     */
    public function cgetAction(ParamFetcher $paramFetcher)
    {
        $recipe     = $paramFetcher->get('recipe');
        $offset     = $paramFetcher->get('offset');
        $limit      = $paramFetcher->get('limit');
        $orderBy    = $paramFetcher->get('order_by');
        $order      = $paramFetcher->get('order');
        $repo       = $this->getRepo();

        // alternatively, 'limit' could be set as strict, in it's annotation, to set it mandatory.
        // however, RestBundle's own error message is too detailed IMHO.
        if (null === $limit ||
            1 > $limit ||
            0 > $offset
        ) {
            return $this->view(null, Codes::HTTP_BAD_REQUEST);
        }

        $entities = null;
        if ($repo instanceof BasicRepository) {
            $entities = $repo->getSome($offset, $limit, $orderBy, $order);
        } elseif ($repo instanceof RecipeRelatedRepository) {
            $entities = $repo->getSome($recipe, $offset, $limit, $orderBy, $order);
        }

        return $this->view(['data' => $entities]);
    }


    /**
     * @param Request $request
     * @return View
     */
    public function postAction(Request $request)
    {
        $entity = $this->getEntity();
        $form   = $this->createForm($this->getFormType(), $entity);
        $form->handleRequest($request);

        return $this->processRequest($request, $entity, $form, Codes::HTTP_CREATED);
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

        $form = $this->createForm($this->getFormType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        return $this->processRequest($request, $entity, $form, Codes::HTTP_NO_CONTENT);
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
     * @param Request   $request
     * @param object    $entity
     * @param Form      $form
     * @param int       $successCode
     * @return View
     */
    protected function processRequest(Request $request, $entity, Form $form, $successCode)
    {
        if (!$form->isValid()) {
            return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
        }

        $this->getEM()->persist($entity);
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
     * @return \Symfony\Component\Form\AbstractType
     */
    protected function getFormType()
    {
        if (null === $this->formType) {
            $namespace      = '\Barra\AdminBundle\Form\Type\\';
            $entity         = $namespace.$this->getEntityClass().'Type';
            $this->formType = new $entity(); //
        }

        return $this->formType;
    }


    /**
     * @return mixed entity
     */
    protected function getEntity()
    {
        if (null === $this->entity) {
            $namespace      = '\Barra\AdminBundle\Entity\\';
            $entity         = $namespace.$this->getEntityClass();
            $this->entity   = new $entity(); //
        }

        return $this->entity;
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
}
