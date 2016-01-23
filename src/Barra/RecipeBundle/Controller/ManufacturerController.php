<?php

namespace Barra\RecipeBundle\Controller;

use Barra\RecipeBundle\Form\ManufacturerType;
use Barra\RecipeBundle\Entity\Manufacturer;
use Symfony\Component\HttpFoundation\Response;

class ManufacturerController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $form = $this->createForm(new ManufacturerType(), new Manufacturer());

        return $this->render(':manufacturer:manufacturers.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
