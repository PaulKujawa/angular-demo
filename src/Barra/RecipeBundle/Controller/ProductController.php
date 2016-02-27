<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends BasicController
{
    /**
     * @Route("/recipes/{pageIndex}", name="barra_recipe_products", defaults={"pageIndex" = 1}, requirements={
     *      "pageIndex" = "\d+"
     * })
     *
     * @param int $pageIndex
     *
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
