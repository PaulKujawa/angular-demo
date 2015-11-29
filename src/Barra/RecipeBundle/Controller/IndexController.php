<?php

namespace Barra\RecipeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class IndexController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Controller
 */
class IndexController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function contactAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', 'text', [
                'attr'  => [
                    'placeholder' => 'recipe.contact.name',
                ],
            ])
            ->add('email', 'email', [
                'attr' => [
                    'placeholder' => 'recipe.contact.email',
                ],
            ])
            ->add('message', 'textarea', [
                'attr'  => [
                    'placeholder' => 'recipe.contact.message',
                ],
            ])
            ->add('submit', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $this->sendMail($form->getData());
            $request
                ->getSession()
                ->getFlashBag()
                ->add('emailSent', $this->get('translator')->trans('recipe.message.emailSent'));

            return $this->redirect($this->generateUrl('barra_recipe_contact'));
        }

        return $this->render('BarraRecipeBundle:Index:contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     */
    public function dashboardAction()
    {
        return $this->render('BarraRecipeBundle:Index:dashboard.html.twig', []);
    }

    /**
     * @param array $enquiry
     */
    protected function sendMail(array $enquiry)
    {
        $mailer = $this->get('mailer');
        $mail   = $mailer->createMessage()
            ->setSubject('Portfolio enquiry from '.$enquiry['name'])
            ->setFrom($enquiry['email'])
            ->setTo('p.kujawa@gmx.net')
            ->setBody($enquiry['message']);
        $mailer->send($mail);
    }
}
