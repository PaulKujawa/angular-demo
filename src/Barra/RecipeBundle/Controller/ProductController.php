<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\ProductType;
use Barra\RecipeBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ProductController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Controller
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

        return $this->render('BarraRecipeBundle:Product:products.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
