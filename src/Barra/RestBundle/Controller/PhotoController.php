<?php

namespace Barra\RestBundle\Controller;

use Barra\AdminBundle\Form\Type\PhotoType;
use Barra\AdminBundle\Entity\Recipe;
use Barra\AdminBundle\Entity\Photo;
use Barra\AdminBundle\Entity\Repository\PhotoRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Annotations;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PhotoController
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Controller
 */
class PhotoController extends AbstractRestController
{
    public function newAction()
    {
        $form = $this->createForm(new PhotoType(), new Photo());
        return ['data' => $form];
    }


    protected function processForm(Request $request, $successCode, $entity = null)
    {
        if (null === $entity) {
            $entity = new Photo();
        } elseif (!$entity instanceof Photo) {
            throw new \InvalidArgumentException(sprintf('entity needs to be of type '.$this->getEntityClass()));
        }

        $requestBody = array_values($request->request->all())[0];
        $recipe      = $this->getRepo('Recipe')->find($requestBody['recipe']);
        $form        = $this->createForm(new PhotoType(), $entity, ['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if (!$form->isValid() ||
            !$recipe instanceof Recipe
        ) {
            return $this->view($form, Codes::HTTP_BAD_REQUEST);
        }

        // TODO check dat
        /** @var UploadedFile $file */
        $file = $request->files[0];

        if ($request->isMethod('POST')) {
            $entity
                ->setRecipe($recipe)
                ->setFile($file)
                ->setSize($file->getClientSize())
            ;
        }

        $duplicate = $this->getRepo()->findOneByName($entity->getName());
        if ($duplicate instanceof Photo) {
            return $this->view($form, Codes::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->persistEntity($request, $entity, $successCode);
    }
}
