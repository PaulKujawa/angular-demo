<?php

namespace Barra\FrontBundle\Controller;

use Barra\FrontBundle\Entity\Repository\RecipeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class RecipeController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Controller
 */
class RecipeController extends Controller
{
    const RANGE = 6;

    /**
     * @param int $paginationActive
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($paginationActive)
    {
        $offset         = ($paginationActive-1)*self::RANGE +1;
        /** @var RecipeRepository $repo */
        $repo           = $this->getDoctrine()->getManager()->getRepository('BarraFrontBundle:Recipe');
        $recipes        = $repo->getSome($offset, self::RANGE, "name", "ASC");
        $paginationCnt  = $repo->count();
        $paginationCnt  = ceil($paginationCnt/self::RANGE);

        return $this->render('BarraFrontBundle:Recipe:recipes.html.twig', [
            'paginationActive'  => $paginationActive,
            'paginationCnt'     => $paginationCnt,
            'recipes'           => $recipes,
        ]);
    }
}
