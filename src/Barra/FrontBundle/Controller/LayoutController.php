<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{
    public function navAction()
    {
        $entries = array(
            0 => array('path'=>'barra_front_me',         'label' => 'about me'),
            1 => array('path'=>'barra_front_references', 'label' => 'reference'),
            2 => array('path'=>'barra_front_recipes',    'label' => 'recipe'),
            3 => array('path'=>'barra_front_contact',    'label' => 'contact')
        );

        return $this->render('BarraFrontBundle::nav.html.twig', array (
           'entries'=>$entries,
           'count'=>0
        ));
    }
}