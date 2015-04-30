<?php

namespace Barra\FrontBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function indexAction($paginationActive)
    {
        $paginationRange = 6;
        $offset = ($paginationActive-1)*$paginationRange +1;
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('BarraFrontBundle:Recipe')->getSome($offset, $paginationRange, "name", "ASC");
        $paginationCnt = $em->getRepository('BarraFrontBundle:Recipe')->count();
        $paginationCnt = ceil($paginationCnt/$paginationRange);

        return $this->render('BarraFrontBundle:Recipe:recipes.html.twig', array(
                'paginationActive' => $paginationActive,
                'paginationCnt' => $paginationCnt,
                'recipes' => $recipes,
            ));
    }
}
