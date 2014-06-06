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



    public function contactGetAction(Request $request)
    {
        $form = $this->createForm("foo");
        $form->handleRequest($request);

        if ($form->isValid()) {
            // processing

            $this->get('session')->getFlashBag()->add(
                'notice',
                'I am informed.'
            );

            return $this->redirect($this->generateUrl('barra_default_home'));
        }

        return $this->render('BarraDefaultBundle:Default:contact.html.twig'); // TODO alert
    }


    public function contactPostAction()
    {
        return $this->render('BarraDefaultBundle:Default:contact.html.twig');
    }
}
