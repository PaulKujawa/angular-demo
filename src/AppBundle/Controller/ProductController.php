<?php

namespace AppBundle\Controller;

use AppBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("is_authenticated()")
 */
class ProductController extends Controller
{
    /**
     * @Route("/admino/products/{page}", name="app_products", defaults={"page" = 1}, requirements={
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
