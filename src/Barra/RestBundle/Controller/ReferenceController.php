<?php

namespace Barra\RestBundle\Controller;

use Barra\BackBundle\Form\Type\ReferenceType;
use Barra\FrontBundle\Entity\Reference;
use Barra\FrontBundle\Entity\Repository\ReferenceRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ReferenceController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class ReferenceController extends FOSRestController
{
    /** @var EntityManager  */
    protected $em;


    /**
     * Returns form
     * @return \Symfony\Component\Form\Form
     */
    public function newReferenceAction()
    {
        $form = $this->createForm(new ReferenceType(), new Reference());

        return ['data' => $form];
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
    public function getReferencesAction(ParamFetcher $paramFetcher)
    {
        $offset     = (int) $paramFetcher->get('offset');
        $limit      = (int) $paramFetcher->get('limit');
        $orderBy    = $paramFetcher->get('order_by');
        $order      = $paramFetcher->get('order');

        /** @var ReferenceRepository $repo */
        $repo       = $this->getRepo();
        $entities   = $repo->getSome($offset, $limit, $orderBy, $order);

        return ['data' => $entities];
    }


    /**
     * Get single entry
     * @Annotations\View()
     * @param int $id
     * @return array
     */
    public function getReferenceAction($id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Reference) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return ['data' => $entity];
    }


    /**
     * Create new entry
     * @param Request $request
     * @return \FOS\RestBundle\View\View
     */
    public function postReferenceAction(Request $request)
    {
        return $this->processForm($request, new Reference(), Codes::HTTP_CREATED);
    }


    /**
     * Replace or create entry
     * @param Request   $request
     * @param int       $id
     * @return array|\FOS\RestBundle\View\View
     */
    public function putReferenceAction(Request $request, $id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Reference) {
            return $this->routeRedirectView('barra_api_post_reference', ['request' => $request]);
        }

        return $this->processForm($request, $entity, Codes::HTTP_NO_CONTENT);
    }


    /**
     * Actual form handling
     * @param Request       $request
     * @param Reference     $entity
     * @param int           $successCode
     * @return \FOS\RestBundle\View\View
     */
    protected function processForm(Request $request, Reference $entity, $successCode)
    {
        $form = $this->createForm(new ReferenceType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid()) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        if ($request->isMethod('POST')) {
//           TODO $entity->setFile()
        }

        $duplicate = $this->getRepo()->findOneByUrl($entity->getUrl());
        if ($duplicate instanceof Reference) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        $this->getEM()->persist($entity);
        $this->getEM()->flush();

        $params = [
            'id'        => $entity->getId(),
            '_format'   => $request->get('_format'),
        ];

        return $this->routeRedirectView('barra_api_get_reference', $params, $successCode);
    }


    /**
     * Delete one reference
     * @Annotations\View()
     * @param int   $id
     * @return \FOS\RestBundle\View\View
     */
    public function deleteReferenceAction($id)
    {
        $entity = $this->getRepo()->find($id);
        if (!$entity instanceof Reference) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        // TODO onDelete=Cascade instead of manually calling ReferencePicture.removeUpload()
        foreach ($entity->getReferencePictures() as $image) {
            $this->getEM()->remove($image);
        }

        $this->getEM()->remove($entity);
        $this->getEM()->flush();

        return $this->view(null, Codes::HTTP_NO_CONTENT);
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
    protected function getRepo($className = 'Reference')
    {
        return $this->getEM()->getRepository('BarraFrontBundle:'.$className);
    }
}
