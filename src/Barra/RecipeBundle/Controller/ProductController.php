<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\ProductType;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $form = $this->createForm(ProductType::class);

        return $this->render(':product:products.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
