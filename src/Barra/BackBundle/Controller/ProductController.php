<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Form\Type\ProductType;
use Barra\FrontBundle\Entity\Product;
use Barra\FrontBundle\Entity\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ProductController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class ProductController extends Controller
{
    const LIMIT = 10;

    /**
     * @param int $paginationActive
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($paginationActive)
    {
        /** @var ProductRepository $repo */
        $offset         = ($paginationActive-1)*self::LIMIT;
        $repo           = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Product');
        $products       = $repo->getSome($offset, self::LIMIT, 'id', 'ASC');
        $paginationCnt  = ceil($repo->count()/self::LIMIT);
        $form           = $this->createForm(new ProductType(), new Product());

        return $this->render('BarraBackBundle:Product:products.html.twig', [
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'products'          => $products,
            'form'              => $form->createView(),
        ]);
    }
}
