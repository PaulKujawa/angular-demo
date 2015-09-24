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
     * @param string    $entityFQDN
     * @param int       $range
     * @throws \InvalidArgumentException
     * @return int
     */
    protected function getPaginationPages($entityFQDN, $range)
    {
        if (!is_string($entityFQDN) ||
            !is_int($range) ||
            $range < 1
        ) {
            throw new \InvalidArgumentException();
        }

        // == false wouldn't work for offset 0
        if (strpos($entityFQDN, ':') === false) {
            $entityFQDN = 'BarraFrontBundle:'.$entityFQDN;
        }

        $repo = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository($entityFQDN)
        ;

        if (!method_exists($repo, 'count')) {
            throw new \RuntimeException();
        }
        $pages = ceil($repo->count() / $range);

        return $pages;
    }
}
