<?php

namespace Barra\AdminBundle\Controller;

use Barra\AdminBundle\Form\Type\ManufacturerType;
use Barra\AdminBundle\Entity\Manufacturer;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ManufacturerController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Controller
 */
class ManufacturerController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $form = $this->createForm(new ManufacturerType(), new Manufacturer());

        return $this->render('BarraAdminBundle:Manufacturer:manufacturers.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
