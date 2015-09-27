<?php

namespace Barra\AdminBundle\Controller;

use Barra\AdminBundle\Entity\Agency;
use Barra\AdminBundle\Form\Type\AgencyType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AgencyController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Controller
 */
class AgencyController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $pages = $this->getPaginationPages('Agency', 10);
        $form  = $this->createForm(new AgencyType(), new Agency());

        return $this->render('BarraAdminBundle:Agency:agencies.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $pages,
            'form'      => $form->createView(),
        ]);
    }
}
