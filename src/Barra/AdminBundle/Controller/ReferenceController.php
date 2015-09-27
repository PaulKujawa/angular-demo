<?php

namespace Barra\AdminBundle\Controller;

use Barra\AdminBundle\Entity\Reference;
use Barra\AdminBundle\Form\Type\ReferenceType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ReferenceController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Controller
 */
class ReferenceController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $pages = $this->getPaginationPages('Reference', 10);
        $form  = $this->createForm(new ReferenceType(), new Reference());

        return $this->render('BarraAdminBundle:Reference:references.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $pages,
            'form'      => $form->createView(),
        ]);
    }
}
