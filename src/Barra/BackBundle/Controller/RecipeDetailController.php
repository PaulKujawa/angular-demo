<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\RecipePicture;
use Barra\FrontBundle\Entity\Cooking;
use Barra\FrontBundle\Entity\RecipeIngredient;
use Barra\BackBundle\Form\Type\RecipePictureType;
use Barra\BackBundle\Form\Type\CookingType;
use Barra\BackBundle\Form\Type\RecipeIngredientType;
use Barra\BackBundle\Form\Type\Update\CookingUpdateType;
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

        $cookings           = $em->getRepository('BarraFrontBundle:Cooking')->findByRecipe($recipe, array('position'=>'ASC'));
        $recipeIngredients  = $em->getRepository('BarraFrontBundle:RecipeIngredient')->findByRecipe($recipe, array('position'=>'ASC'));

        $recipePicture      = new RecipePicture();
        $cooking            = new Cooking();
        $recipeIngredient   = new RecipeIngredient();

        $formRecipePicture      = $this->createForm(new RecipePictureType(), $recipePicture);
        $formCookingInsert      = $this->createForm(new CookingType(), $cooking);
        $formIngredientInsert   = $this->createForm(new RecipeIngredientType(), $recipeIngredient);
        $formCookingUpdate      = $this->createForm(new CookingUpdateType(), new Cooking());
        $formIngredientUpdate   = $this->createForm(new RecipeIngredientUpdateType(), new RecipeIngredient());

        $formRecipePicture->get('recipe')->setData($recipe->getId());
        $formCookingUpdate->get('recipe')->setData($recipe->getId());
        $formIngredientUpdate->get('recipe')->setData($recipe->getId());

        if ($request->getMethod() === 'POST') {
            $sqlError = null;
            if ($request->request->has($formIngredientInsert->getName())) {
                $formIngredientInsert->handleRequest($request);
                if ($formIngredientInsert->isValid())
                    $sqlError = $this->newIngredient($recipe, $recipeIngredient);
            } elseif ($request->request->has($formCookingInsert->getName())) {
                $formCookingInsert->handleRequest($request);
                if ($formCookingInsert->isValid())
                    $sqlError = $this->newCooking($recipe, $cooking);
            }
            if ($sqlError)
                $formIngredientInsert->addError(new FormError($sqlError));
            else
                return $this->redirect($this->generateUrl('barra_back_recipeDetail', array('name' => $name)));
        }


        return $this->render('BarraBackBundle:Recipe:recipeDetail.html.twig', array(
                'recipe'                => $recipe,
                'cookings'              => $cookings,
                'recipeIngredients'     => $recipeIngredients,
                'formRecipePicture'     => $formRecipePicture->createView(),
                'formIngredientInsert'  => $formIngredientInsert->createView(),
                'formIngredientUpdate'  => $formIngredientUpdate->createView(),
                'formCookingInsert'     => $formCookingInsert->createView(),
                'formCookingUpdate'     => $formCookingUpdate->createView()
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



    public function newCooking($recipe, $cooking)
    {
        $em = $this->getDoctrine()->getManager();
        $nextPosition = $em->getRepository('BarraFrontBundle:Cooking')->getHighestPosition($recipe->getId()) +1;
        $cooking->setPosition($nextPosition);
        $cooking->setRecipe($recipe);
        $em = $this->getDoctrine()->getManager();
        $em->persist($cooking);
        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Cooking step could not be inserted');
        }
        return null;
    }



    public function uploadPictureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeId = $request->request->get('formRecipePicture')['recipe'];
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);

        if (!$recipe)
            throw $this->createNotFoundException('Recipe not found');

        foreach($request->files as $file) { // not necessary, since dropzone sends for every file an own request which depends on current config
            $recipeFile = new RecipePicture();

            $form = $this->createForm(new RecipePictureType(), $recipeFile);
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



    public function getPicturesAction($recipeId)
    {
        $em = $this->getDoctrine()->getManager();
        $files = $em->getRepository('BarraFrontBundle:RecipePicture')->findByRecipe($recipeId);

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



    public function deletePictureAction($recipeId, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('BarraFrontBundle:RecipePicture')->find($id);

        if (!$file)
            throw $this->createNotFoundException('File not found');

        $em->remove($file);
        $em->flush();

        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);
        return $this->redirect($this->generateUrl('barra_back_recipeDetail', array('name'=>$recipe->getName())));
    }
}
