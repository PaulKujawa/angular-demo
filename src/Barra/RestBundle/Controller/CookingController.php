<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Entity\Recipe;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CookingController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class CookingController extends RestController
{
    protected function processRequest(Request $request, $entity, Form $form, $successCode)
    {
        if ($request->isMethod('POST')) {
            $requestBody = array_values($request->request->all())[0];
            $recipe      = $this->getRepo('Recipe')->find($requestBody['recipe']);

            if (!$recipe instanceof Recipe) {
                return $this->view($form, Codes::HTTP_BAD_REQUEST);
            }

            $position = $this->getRepo()->getNextPosition($recipe->getId());
            $entity
                ->setPosition($position)
                ->setRecipe($recipe)
            ;
        }

        return parent::processRequest($request, $entity, $form, $successCode);
    }
}
