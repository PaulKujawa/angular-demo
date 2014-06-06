<?php

namespace Barra\DefaultBundle\Controller;

use Doctrine\DBAL\Driver\IBMDB2\DB2Exception;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('BarraDefaultBundle:Default:index.html.twig');
    }


    public function recipeAction($id)
    {
        $dbResponse = true;
        if (!$dbResponse) {
            throw $this->createNotFoundException('This recipe does not exist yet');
        }

        return $this->render('BarraDefaultBundle:Default:recipe.html.twig', array('id' => $id));
    }

    
}
