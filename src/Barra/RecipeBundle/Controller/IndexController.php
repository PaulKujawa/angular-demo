<?php

namespace Barra\RecipeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function contactAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, [
                'attr'  => [
                    'placeholder' => 'recipe.contact.name',
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'recipe.contact.email',
                ],
            ])
            ->add('message', TextareaType::class, [
                'attr'  => [
                    'placeholder' => 'recipe.contact.message',
                ],
            ])
            ->add('submit', SubmitType::class)
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

        return $this->render(':index:contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return Response
     */
    public function dashboardAction()
    {
        return $this->render(':index:dashboard.html.twig', []);
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
