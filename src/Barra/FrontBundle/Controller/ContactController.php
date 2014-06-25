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


        $msg = $this->get('translator')->trans('hey', array(), 'messages');
        return new Response($msg);

        //return new Response($msg);


    //   return $this->render('BarraFrontBundle:Contact:contact.html.twig', array (
     //      'foo'=>$msg
      //  ));
    }


    public function postAction()
    {
        return $this->render('BarraFrontBundle:Contact:contact.html.twig');
    }
}