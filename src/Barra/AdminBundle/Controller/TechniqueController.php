<?php

namespace Barra\AdminBundle\Controller;

use Barra\AdminBundle\Entity\Technique;
use Barra\AdminBundle\Form\Type\TechniqueType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TechniqueController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Controller
 */
class TechniqueController extends BasicController
{
    /**
     * @param int $pageIndex
     * @return Response
     */
    public function indexAction($pageIndex)
    {
        $form = $this->createForm(new TechniqueType(), new Technique());

        return $this->render('BarraAdminBundle:Technique:techniques.html.twig', [
            'pageIndex' => $pageIndex,
            'pages'     => $this->getPaginationPages(),
            'form'      => $form->createView(),
        ]);
    }
}
