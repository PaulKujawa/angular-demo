<?php

namespace Barra\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Controller
 */
class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('BarraBackBundle:User:user.html.twig', []);
    }
}
