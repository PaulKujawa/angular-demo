<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Technique;
use Barra\BackBundle\Form\Type\TechniqueType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TechniqueController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class TechniqueController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $pages = $this->getPaginationPages('Reference', 10);
        $form  = $this->createForm(new TechniqueType(), new Technique());

        return $this->render('BarraBackBundle:Reference:references.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $pages,
            'form'      => $form->createView(),
        ]);
    }
}
