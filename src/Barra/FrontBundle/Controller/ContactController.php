<?php

namespace Barra\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{

    public function getAction(Request $request)
    {
       /* $form = $this->createForm("foo");
        $form->handleRequest($request);

        if ($form->isValid()) {
            // processing

            $this->get('session')->getFlashBag()->add(
                'notice',
                'I am informed.'
            );

            return $this->redirect($this->generateUrl('barra_default_home'));
        }*/

        return $this->render('BarraFrontBundle:Contact:contact.html.twig');
    }


    public function postAction()
    {
        return $this->render('BarraFrontBundle:Contact:contact.html.twig');
    }
}
