<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Form\Type\ProductType;
use Barra\FrontBundle\Entity\Product;
use Barra\FrontBundle\Entity\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProductController extends Controller
{
    const LIMIT = 10;

    public function indexAction($paginationActive)
    {
        /** @var ProductRepository $repo */
        $offset         = ($paginationActive-1)*self::LIMIT;
        $repo           = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Product');
        $products       = $repo->getSome($offset, self::LIMIT, 'id', 'ASC');
        $paginationCnt  = $repo->count();
        $paginationCnt  = ceil($paginationCnt/self::LIMIT);
        $form           = $this->createForm(new ProductType(), new Product());

        return $this->render('BarraBackBundle:Product:products.html.twig', array(
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'products'          => $products,
            'form'              => $form->createView(),
        ));
    }
}