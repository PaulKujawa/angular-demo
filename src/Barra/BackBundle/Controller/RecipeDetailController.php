<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\CookingStep;
use Barra\FrontBundle\Entity\RecipeIngredient;
use Barra\BackBundle\Form\Type\CookingStepType;
use Barra\BackBundle\Form\Type\RecipeIngredientType;
use Barra\BackBundle\Form\Type\RecipeIngredientUpdateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeDetailController extends Controller
{
    public function indexAction($name, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->findOneByName(str_replace('_', ' ', $name));
        $cookingSteps = $em->getRepository('BarraFrontBundle:CookingStep')->findBy(array('recipe'=>$recipe), array('step'=>'ASC'));
        $recipeIngredients = $em->getRepository('BarraFrontBundle:RecipeIngredient')->findByRecipe($recipe, array('position'=>'ASC'));


        $recipeIngredient = new RecipeIngredient();
        $formIngredient = $this->createForm(new RecipeIngredientType(), $recipeIngredient);

        $cookingStep = new CookingStep();
        $formCookingStep = $this->createForm(new CookingStepType(), $cookingStep);


        if ($request->getMethod() === 'POST') {
            if ($request->request->has($formIngredient->getName())) {
                $formIngredient->handleRequest($request);
                if ($formIngredient->isValid())
                   $sqlError = $this->newIngredientAction($recipe, $recipeIngredient);

            } elseif ($request->request->has($formCookingStep->getName())) {
                $formCookingStep->handleRequest($request);
                if ($formCookingStep->isValid())
                    $sqlError = $this->newCookingStepAction($recipe, $cookingStep);
            }

            if ($sqlError)
                return new Response($sqlError);
            return $this->redirect($this->generateUrl('barra_back_recipe', array('name' => $name)));
        }

        $formIngredientUpdate = $this->createForm(new RecipeIngredientUpdateType(), $recipeIngredient);

        return $this->render('BarraBackBundle:Recipe:recipeDetail.html.twig', array(
            'recipe' => $recipe,
            'cookingSteps'=> $cookingSteps,
            'recipeIngredients'=>$recipeIngredients,
            'formIngredient' => $formIngredient->createView(),
            'formIngredientUpdate' => $formIngredientUpdate->createView(),
            'formCookingStep' => $formCookingStep->createView()
        ));
    }


















    public function newIngredientAction($recipe, $recipeIngredient)
    {
        $recipeIngredient->setRecipe($recipe)->setPosition(1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($recipeIngredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Recipe relation could not be inserted');
        }
        return null;
    }



    public function updateIngredientAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeId = $request->request->get('formRecipeIngredientUpdate')['recipe'];
        $ingredientId = $request->request->get('formRecipeIngredientUpdate')['ingredient'];
        $recipeIngredient = $em->getRepository('BarraFrontBundle:RecipeIngredient')->findOneBy(array('recipe'=>$recipeId, 'ingredient'=>$ingredientId));

        if (!$recipeIngredient) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new RecipeIngredientUpdateType(), $recipeIngredient);
        $formUpdate->handleRequest($request);

        if ($formUpdate->isValid()) {
            $em->flush();
            $ajaxResponse = array("code"=>200, "message"=>"ok");
        } else {
            $validationErrors = $this->getErrorMessages($formUpdate);
            $ajaxResponse = array("code"=>400, "message"=>$validationErrors);
        }

        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }



    public function deleteIngredientAction($recipeId, $ingredientId)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeIngredient = $em->getRepository('BarraFrontBundle:RecipeIngredient')->findOneBy(array('recipe'=>$recipeId, 'ingredient'=>$ingredientId));

        if (!$recipeIngredient)
            throw $this->createNotFoundException('Relation not found');

        $em->remove($recipeIngredient);
        $em->flush();

        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);
        return $this->redirect($this->generateUrl('barra_back_recipe', array('name'=>$recipe->getName())));
    }




































    public function newCookingStepAction($recipe, $cookingStep)
    {
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



    /*public function updateCookingStepAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('formManufacturerUpdate')['id'];
        $manufacturer = $em->getRepository('BarraFrontBundle:Manufacturer')->find($id);

        if (!$manufacturer) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }


        $formUpdate = $this->createForm(new RecipeIngredientUpdateType(), $manufacturer);
        $formUpdate->handleRequest($request);

        if ($formUpdate->isValid()) {
            $em->flush();
            $ajaxResponse = array("code"=>200, "message"=>"ok");
        } else {
            $validationErrors = $this->getErrorMessages($formUpdate);
            $ajaxResponse = array("code"=>400, "message"=>$validationErrors);
        }

        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }*/



    /**
     * @param Form $form
     * @return array[fieldName][number] e.g. array['name'][0]
     */
    private function getErrorMessages(Form $form) {
        $errors = array();
        $formErrors = $form->getErrors();

        foreach ($formErrors as $key => $error) {
            $errors[] = $error->getMessage();
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid())
                $errors[$child->getName()] = $this->getErrorMessages($child);
        }
        return $errors;
    }



    public function deleteCookingStepAction($recipeId, $step)
    {
        $em = $this->getDoctrine()->getManager();
        $cooking = $em->getRepository('BarraFrontBundle:CookingStep')->findOneBy(array('recipe'=>$recipeId, 'step'=>$step));

        if (!$cooking)
            throw $this->createNotFoundException('Cooking step not found');

        $em->remove($cooking);
        $em->flush();

        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);
        return $this->redirect($this->generateUrl('barra_back_recipe', array('name'=>$recipe->getName())));
    }
}
