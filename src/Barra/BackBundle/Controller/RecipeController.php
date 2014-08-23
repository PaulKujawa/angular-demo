<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Barra\BackBundle\Form\Type\RecipeType;
use Barra\BackBundle\Form\Type\RecipeUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function indexAction(Request $request)
    {
        $recipe = new Recipe();
        $formInsert = $this->createForm(new RecipeType(), $recipe);
        $formInsert->handleRequest($request);

        if ($formInsert->isValid()) {
            $sqlError = $this->newRecipeAction($recipe);

            if ($sqlError)
                $formInsert->addError(new FormError($sqlError));
            else
                return $this->redirect($this->generateUrl('barra_back_recipe', array('name' => $recipe->getName())));
        }


        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('BarraFrontBundle:Recipe')->findAll();
        $formUpdate = $this->createForm(new RecipeUpdateType(), $recipe);

        return $this->render('BarraBackBundle:Recipe:recipes.html.twig', array(
            'recipes' => $recipes,
            'formInsert' => $formInsert->createView(),
            'formUpdate' => $formUpdate->createView()
        ));
    }


    public function newRecipeAction($recipe)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe->setRating(50)->setVotes(2);
        $em->persist($recipe);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return $this->get('translator')->trans("back.message.insertError");
        }
        return null;
    }



    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('formRecipeUpdate')['id'];
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);

        if (!$recipe) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new RecipeUpdateType(), $recipe);
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



    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);

        if (!$recipe)
            throw $this->createNotFoundException('Recipe not found');
        $em->remove($recipe);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response($e);
        }

        return $this->redirect($this->generateUrl('barra_back_recipes'));
    }
}
