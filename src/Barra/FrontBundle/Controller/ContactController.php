<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;


class ContactController extends Controller
{
    public function getAction(Request $request)
    {
        /*
            TODO language button
            $request->setLocale('en');
        */


        $name = 'Paul';
        $translated = $this->get('translator')->trans('hey');



       return $this->render('BarraFrontBundle:Contact:contact.html.twig', array (
           'name'=>$name
        ));
    }
}