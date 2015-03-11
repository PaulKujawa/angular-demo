<?php

namespace Barra\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('BarraBackBundle:User:user.html.twig', array());
    }
}