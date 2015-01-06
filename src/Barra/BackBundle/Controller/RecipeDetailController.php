<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\UploadedImage;
use Barra\FrontBundle\Entity\CookingStep;
use Barra\FrontBundle\Entity\RecipeIngredient;
use Barra\BackBundle\Form\Type\UploadedImageType;
use Barra\BackBundle\Form\Type\CookingStepType;
use Barra\BackBundle\Form\Type\RecipeIngredientType;
use Barra\BackBundle\Form\Type\Update\CookingStepUpdateType;
use Barra\BackBundle\Form\Type\Update\RecipeIngredientUpdateType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeDetailController extends Controller
{
    public function indexAction($name, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->findOneByName(str_replace('_', ' ', $name));
        if (!$recipe)
            throw $this->createNotFoundException('Recipe not found');

        $cookingSteps           = $em->getRepository('BarraFrontBundle:CookingStep')->findByRecipe($recipe, array('position'=>'ASC'));
        $recipeIngredients      = $em->getRepository('BarraFrontBundle:RecipeIngredient')->findByRecipe($recipe, array('position'=>'ASC'));

        $recipeFile             = new UploadedImage();
        $cookingStep            = new CookingStep();
        $recipeIngredient       = new RecipeIngredient();

        $formUploadedImage      = $this->createForm(new UploadedImageType(), $recipeFile);
        $formCookingStepInsert  = $this->createForm(new CookingStepType(), $cookingStep);
        $formCookingStepUpdate  = $this->createForm(new CookingStepUpdateType(), $cookingStep);
        $formIngredientInsert   = $this->createForm(new RecipeIngredientType(), $recipeIngredient);
        $formIngredientUpdate   = $this->createForm(new RecipeIngredientUpdateType(), $recipeIngredient);

        $formUploadedImage->get('recipe')->setData($recipe->getId());
        $formCookingStepUpdate->get('recipe')->setData($recipe->getId());
        $formIngredientUpdate->get('recipe')->setData($recipe->getId());

        if ($request->getMethod() === 'POST') {
            $sqlError = null;
            if ($request->request->has($formIngredientInsert->getName())) {
                $formIngredientInsert->handleRequest($request);
                if ($formIngredientInsert->isValid())
                    $sqlError = $this->newIngredient($recipe, $recipeIngredient);
            } elseif ($request->request->has($formCookingStepInsert->getName())) {
                $formCookingStepInsert->handleRequest($request);
                if ($formCookingStepInsert->isValid())
                    $sqlError = $this->newCookingStep($recipe, $cookingStep);
            }
            if ($sqlError)
                $formIngredientInsert->addError(new FormError($sqlError));
            else
                return $this->redirect($this->generateUrl('barra_back_recipeDetail', array('name' => $name)));
        }


        return $this->render('BarraBackBundle:Recipe:recipeDetail.html.twig', array(
                'recipe'                => $recipe,
                'cookingSteps'          => $cookingSteps,
                'recipeIngredients'     => $recipeIngredients,
                'formUploadedImage'     => $formUploadedImage->createView(),
                'formIngredientInsert'  => $formIngredientInsert->createView(),
                'formIngredientUpdate'  => $formIngredientUpdate->createView(),
                'formCookingStepInsert' => $formCookingStepInsert->createView(),
                'formCookingStepUpdate' => $formCookingStepUpdate->createView()
            ));
    }



    public function newIngredient($recipe, $recipeIngredient)
    {
        $em = $this->getDoctrine()->getManager();
        $nextPosition = $em->getRepository('BarraFrontBundle:RecipeIngredient')->getHighestPosition($recipe->getId()) +1;
        $recipeIngredient->setRecipe($recipe);
        $recipeIngredient->setPosition($nextPosition);
        $em = $this->getDoctrine()->getManager();
        $em->persist($recipeIngredient);
        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return $this->get('translator')->trans("back.message.insertError");
        }
        return null;
    }



    public function newCookingStep($recipe, $cookingStep)
    {
        $em = $this->getDoctrine()->getManager();
        $nextPosition = $em->getRepository('BarraFrontBundle:CookingStep')->getHighestPosition($recipe->getId()) +1;
        $cookingStep->setPosition($nextPosition);
        $cookingStep->setRecipe($recipe);
        $em = $this->getDoctrine()->getManager();
        $em->persist($cookingStep);
        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Cooking step could not be inserted');
        }
        return null;
    }



    public function uploadFileAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeId = $request->request->get('formUploadedImage')['recipe'];
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);

        if (!$recipe)
            throw $this->createNotFoundException('Recipe not found');

        foreach($request->files as $file) { // not necessary, since dropzone sends for every file an own request which depends on current config
            $recipeFile = new UploadedImage();

            $form = $this->createForm(new UploadedImageType(), $recipeFile);
            $form->handleRequest($request);
            $recipeFile->setRecipe($recipe);
            $recipeFile->setSize($file->getClientSize());
            $recipeFile->setFile($file);

            if ($form->isValid()) {
                $em->persist($recipeFile);
                $em->flush();
                $id = $recipeFile->getId();
                $ajaxResponse = array("code"=>404, "id"=>$id);
            } else {
                $validationError = $this->get('barra_back.formValidation')->getErrorMessages($form);
                $ajaxResponse = array("code"=>400, "message"=>$validationError);
            }
        }
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function getFilesAction($recipeId)
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('BarraFrontBundle:UploadedImage')->findByRecipe($recipeId);

        $container = array();
        for ($i=0; $i < count($files); $i++) {
            $container[$i]['id']        = $files[$i]->getId();
            $container[$i]['title']     = $files[$i]->getTitle();
            $container[$i]['filename']  = $files[$i]->getFilename();
            $container[$i]['size']      = $files[$i]->getSize();
        }

        $ajaxResponse = array("code"=>200, "files"=>$container);
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function deleteFileAction($recipeId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('BarraFrontBundle:UploadedImage')->findOneBy(array('recipe'=>$recipeId, 'id'=>$id));

        if (!$file)
            throw $this->createNotFoundException('File not found');

        $em->remove($file);
        $em->flush();

        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);
        return $this->redirect($this->generateUrl('barra_back_recipeDetail', array('name'=>$recipe->getName())));
    }
}
