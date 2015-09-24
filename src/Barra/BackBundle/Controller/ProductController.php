<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Form\Type\ProductType;
use Barra\FrontBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class ProductController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $pages = $this->getPaginationPages('Reference', 10);
        $form  = $this->createForm(new ProductType(), new Product());

        return $this->render('BarraBackBundle:Reference:references.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $pages,
            'form'      => $form->createView(),
        ]);
    }
}
