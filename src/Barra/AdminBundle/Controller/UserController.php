<?php

namespace Barra\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Controller
 */
class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('BarraAdminBundle:User:user.html.twig', []);
    }
}
