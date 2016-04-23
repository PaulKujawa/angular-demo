<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * @Route("/admino/products/{page}", name="barra_recipe_products", defaults={"page" = 1}, requirements={
     *      "page" = "\d+"
     * })
     *
     * @param int $page
     *
     * @return Response
     */
    public function indexAction($page)
    {
        $form = $this->createForm(ProductType::class);

        return $this->render(':product:products.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
