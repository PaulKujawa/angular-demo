<?php

namespace Barra\AdminBundle\Controller;

use Barra\AdminBundle\Form\Type\ProductType;
use Barra\AdminBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Controller
 */
class ProductController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $form = $this->createForm(new ProductType(), new Product());

        return $this->render('BarraAdminBundle:Product:products.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
