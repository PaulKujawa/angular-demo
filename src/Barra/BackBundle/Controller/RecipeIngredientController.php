<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\RecipeIngredient;
use Barra\BackBundle\Form\Type\RecipeIngredientUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeIngredientController extends Controller
{
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $ingredientId = $request->request->get('formRecipeIngredientUpdate')['ingredient'];
        $recipeId = $request->request->get('formRecipeIngredientUpdate')['recipe'];
        $recipeIngredient = $em->getRepository('BarraFrontBundle:RecipeIngredient')->findOneBy(array('recipe'=>$recipeId, 'ingredient'=>$ingredientId));


        if (!$recipeIngredient) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new RecipeIngredientUpdateType(), $recipeIngredient);
        $formUpdate->handleRequest($request);

        if ($formUpdate->isValid()) {
            try {
                $em->flush();
                $ajaxResponse = array("code"=>200, "message"=>"ok");
            } catch (\Doctrine\DBAL\DBALException $e) {
                $validationErrors = $this->get('translator')->trans("back.message.insertError");
                $ajaxResponse = array("code"=>409, "dbError"=>$validationErrors);
            }
        } else {
            $validationErrors = $this->get('barra_back.formValidation')->getErrorMessages($formUpdate);
            $ajaxResponse = array("code"=>400, "fieldError"=>$validationErrors);
        }

        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function deleteAction($recipeId, $ingredientId)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeIngredient = $em->getRepository('BarraFrontBundle:RecipeIngredient')->findOneBy(array('recipe'=>$recipeId, 'ingredient'=>$ingredientId));

        if (!$recipeIngredient)
            throw $this->createNotFoundException('Relation not found');

        $em->remove($recipeIngredient);
        $em->flush();

        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);
        return $this->redirect($this->generateUrl('barra_back_recipeDetail', array('name'=>$recipe->getName())));
    }



    public function swapAction($recipeId, $posBefore, $posAfter)
    {
        $em = $this->getDoctrine()->getManager();
        $swappedEntry = $em->getRepository('BarraFrontBundle:RecipeIngredient')->findOneBy(array('recipe'=>$recipeId, 'position'=>$posBefore));
        $swappedEntry->setPosition($posAfter);

        if ($posBefore < $posAfter)
            $steps = $em->getRepository('BarraFrontBundle:RecipeIngredient')->changeBetweenPos($recipeId, $posBefore+1, $posAfter, -1);
        else
            $steps = $em->getRepository('BarraFrontBundle:RecipeIngredient')->changeBetweenPos($recipeId, $posAfter, $posBefore-1, 1);

        try {
            $em->flush();
            $ajaxResponse = array("code"=>200);
        } catch (\Doctrine\DBAL\DBALException $e) {
            $ajaxResponse = array("code"=>400);
        }
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }
}