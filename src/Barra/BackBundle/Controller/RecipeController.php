<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Form\Type\RecipeType;
use Barra\FrontBundle\Entity\Recipe;
use Barra\FrontBundle\Entity\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class RecipeController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class RecipeController extends Controller
{
    const LIMIT = 10;

    /**
     * @param int $paginationActive
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($paginationActive)
    {
        /** @var RecipeRepository $repo */
        $offset         = ($paginationActive-1)*self::LIMIT;
        $repo           = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Recipe');
        $recipes        = $repo->getSome($offset, self::LIMIT, 'id', 'ASC');
        $paginationCnt  = ceil($repo->count()/self::LIMIT);
        $form           = $this->createForm(new RecipeType(), new Recipe());

        return $this->render('BarraBackBundle:Recipe:recipes.html.twig', [
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'recipes'           => $recipes,
            'form'              => $form->createView(),
        ]);
    }
}
