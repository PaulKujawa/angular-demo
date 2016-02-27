<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\ManufacturerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ManufacturerController extends BasicController
{
    /**
     * @Route("/recipes/{pageIndex}", name="barra_recipe_manufacturers", defaults={"pageIndex" = 1}, requirements={
     *      "pageIndex" = "\d+"
     * })
     *
     * @param int $pageIndex
     *
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $form = $this->createForm(ManufacturerType::class);

        return $this->render(':manufacturer:manufacturers.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
