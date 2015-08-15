<?php

namespace Barra\BackBundle\Controller;

use Barra\BackBundle\Form\Type\RecipeType;
use Barra\FrontBundle\Entity\Recipe;
use Barra\FrontBundle\Entity\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    const LIMIT = 10;

    public function indexAction($paginationActive)
    {
        /** @var RecipeRepository $repo */
        $offset         = ($paginationActive-1)*self::LIMIT;
        $repo           = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Recipe');
        $recipes        = $repo->getSome($offset, self::LIMIT, 'id', 'ASC');
        $paginationCnt  = $repo->count();
        $paginationCnt  = ceil($paginationCnt/self::LIMIT);
        $form           = $this->createForm(new RecipeType(), new Recipe());

        return $this->render('BarraBackBundle:Recipe:recipes.html.twig', array(
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'recipes'           => $recipes,
            'form'              => $form->createView(),
        ));
    }
}
