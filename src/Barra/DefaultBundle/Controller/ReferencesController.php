<?php

namespace Barra\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReferencesController extends Controller
{
    public function showAction($lang)
    {
        if ($lang == 'de') {
            // db german content
        } else {
            // db english content
        }

        return $this->render('BarraDefaultBundle:Default:references.html.twig');
    }
}
