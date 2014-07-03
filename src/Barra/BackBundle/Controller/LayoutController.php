<?php

namespace Barra\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{
    public function navAction($request)
    {
        $entries = array(
            0 => array('path'=>'barra_back_admin',          'label' => 'overview'),
            1 => array('path'=>'barra_back_references',     'label' => 'references'),
            2 => array('path'=>'barra_back_recipes',        'label' => 'recipes'),
            3 => array('path'=>'barra_back_ingredients',    'label' => 'ingredients'),
            4 => array('path'=>'barra_back_manufacturers',  'label' => 'manufacturers'),
            5 => array('path'=>'barra_back_measurements',   'label' => 'measurements'),
        );

        return $this->render('BarraBackBundle::nav.html.twig', array (
            'entries'=>$entries,
            'request'=>$request
        ));
    }
}