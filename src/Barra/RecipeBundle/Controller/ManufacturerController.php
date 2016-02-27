<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\ManufacturerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ManufacturerController extends BasicController
{
    /**
     * @Route("/admino/recipes/{page}", name="barra_recipe_manufacturers", defaults={"page" = 1}, requirements={
     *      "page" = "\d+"
     * })
     *
     * @param int $page
     *
     * @return Response
     */
    public function indexAction($page)
    {
        $form = $this->createForm(ManufacturerType::class);

        return $this->render(':manufacturer:manufacturers.html.twig', [
            'page' => $page,
            'pages' => $this->getPaginationPages(),
            'form' => $form->createView(),
        ]);
    }
}
