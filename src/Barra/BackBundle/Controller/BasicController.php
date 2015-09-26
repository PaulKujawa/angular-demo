<?php

namespace Barra\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class BasicController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class BasicController extends Controller
{
    /**
     * @param string    $entityClass
     * @param int       $range
     * @throws \InvalidArgumentException
     * @return int
     */
    protected function getPaginationPages($entityClass, $range)
    {
        if (!is_string($entityClass) ||
            !is_int($range) ||
            $range < 1
        ) {
            throw new \InvalidArgumentException();
        }

        $repo = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BarraBackBundle:'.$entityClass)
        ;

        if (!method_exists($repo, 'count')) {
            throw new \RuntimeException();
        }
        $pages = ceil($repo->count() / $range);

        return $pages;
    }
}
