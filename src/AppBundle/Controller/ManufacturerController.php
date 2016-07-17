<?php

namespace AppBundle\Controller;

use AppBundle\Form\ManufacturerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


class ManufacturerController extends Controller
{
    /**
     * @Route("/admino/manufacturers/{page}", name="app_manufacturers", defaults={"page" = 1}, requirements={
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
            'form' => $form->createView(),
        ]);
    }
}
