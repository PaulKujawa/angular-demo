<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="app_root_i18n")
     * @Route("/recipes/{page}", name="app_recipes", defaults={"page" = 1}, requirements={"page" = "\d+"})
     * @Route("/recipes/{id}/{name}", name="app_recipe", requirements={"id" = "\d+"})
     *
     * @return Response
     */
    public function indexAction(): Response
    {
        return $this->render('::base.html.twig');
    }

    /**
     * @Security("is_authenticated()")
     *
     * @Route("/measurements", name="app_measurements")
     * @Route("/products", name="app_products")
     *
     * @return Response
     */
    public function adminAction(): Response
    {
        return $this->render('::base.html.twig');
    }
}
