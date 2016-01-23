<?php

namespace Barra\RestBundle\Controller;

use Barra\RecipeBundle\Entity\Photo;
use Barra\RecipeBundle\Entity\Recipe;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PhotoController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class PhotoController extends RestController
{
    /**
     * @param int $id
     * @return View
     */
    public function getRecipeAction($id)
    {
        $entity = $this->getRepo()->find($id);

        if (!$entity instanceof Photo) {
            return $this->view(null, Codes::HTTP_NOT_FOUND);
        }

        return $this->view(['data' => $entity->getRecipe()]);
    }

    protected function processRequest(Request $request, $entity, $successCode)
    {
        if ($request->isMethod('POST')) {
            $requestBody = array_values($request->request->all());

            if (empty($requestBody)) {
                $form = $this->createForm($this->getFormType(), $entity, ['method' => $request->getMethod()]);

                return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
            }

            $recipe = $this->getRepo('Recipe')->find($requestBody[0]['recipe']);

            if (!$recipe instanceof Recipe) {
                $form = $this->createForm($this->getFormType(), $entity, ['method' => $request->getMethod()]);

                return $this->view(['data' => $form], Codes::HTTP_BAD_REQUEST);
            }
            $entity->setRecipe($recipe);
        }

        return parent::processRequest($request, $entity, $successCode);
    }
}
