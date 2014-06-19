<?php

namespace Barra\SecurityBundle\Controller;

use Symfony\Component\Security\Core\Util\SecureRandom;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContextInterface::AUTHENTICATION_ERROR);

        } elseif ($session !== null && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);

        } else
            $error = '';

        $lastUsername = ($session === null) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return $this->render('BarraSecurityBundle:Security:login.html.twig', array(
            'last_username' => $lastUsername, 'error' => $error
        ));
    }


    private function secureRandomNumber()
    {
        $generator = new SecureRandom();
        $random = $generator->nextBytes(10);
    }
}