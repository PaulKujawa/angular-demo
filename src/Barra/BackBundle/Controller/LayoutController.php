<?php

namespace Barra\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LayoutController extends Controller
{
    public function navAction()
    {
        $entries = array(
            0 => array('path'=>'barra_back_admin',          'label' => 'overview'),
            1 => array('path'=>'barra_back_references',     'label' => 'reference'),
            2 => array('path'=>'barra_back_recipes',        'label' => 'recipe'),
            3 => array('path'=>'barra_back_ingredients',    'label' => 'ingredient'),
            4 => array('path'=>'barra_back_manufacturers',  'label' => 'manufacturer'),
            5 => array('path'=>'barra_back_measurements',   'label' => 'measurement'),

        );

        return $this->render('BarraBackBundle::nav.html.twig', array (
           'entries'=>$entries,
           'count'=>0
        ));
    }
}