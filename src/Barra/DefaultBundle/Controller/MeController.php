<?php

namespace Barra\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction($lang)
    {
        if ($lang == 'de') {
            // db german content
        } else {
            // db english content
        }

        return $this->render('BarraDefaultBundle:Default:index.html.twig');
    }
}
