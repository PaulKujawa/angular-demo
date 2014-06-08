<?php

namespace Barra\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReferenceController extends Controller
{
    public function showAction($lang, $id)
    {
        if ($lang == 'de') {
            // db german content
        } else {
            // db english content
        }

        return $this->render('BarraDefaultBundle:Reference:reference.html.twig', array('id' => $id));
    }
}
