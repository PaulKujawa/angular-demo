<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\CookingStep;
use Barra\BackBundle\Form\Type\CookingStepType;
use Barra\FrontBundle\Entity\RecipeIngredient;
use Barra\BackBundle\Form\Type\RecipeIngredientType;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function indexAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($id);

        $cookingSteps = $em->getRepository('BarraFrontBundle:CookingStep')->findBy(
            array('recipe'=>$recipe), array('step'=>'ASC'));

        $recipeIngredients = $em->getRepository('BarraFrontBundle:RecipeIngredient')->findBy(
            array('recipe'=>$recipe), array('position'=>'ASC'));

        $recipeIngredient = new RecipeIngredient();
        $formRecipeIngredient = $this->createForm(new RecipeIngredientType(), $recipeIngredient);

        $cookingStep = new CookingStep();
        $formCookingStep = $this->createForm(new CookingStepType(), $cookingStep);


        if ($request->getMethod() === 'POST' && $request->request->has($formRecipeIngredient->getName()))
        {
            $formRecipeIngredient->handleRequest($request);
            if ($formRecipeIngredient->isValid()) {
                $recipeIngredient->setRecipe($recipe);
                $recipeIngredient->setPosition(1);
                $sqlError = $this->newRecipeIngredientAction($recipeIngredient);

                if ($sqlError)
                    return new Response($sqlError);

                $id = $recipe->getId();
                return $this->redirect($this->generateUrl('barra_back_recipe', array('id' => $id)));
            }
        }


        if ($request->getMethod() === 'POST' && $request->request->has($formCookingStep->getName()))
        {
            $formCookingStep->handleRequest($request);
            if ($formCookingStep->isValid()) {
                $cookingStep->setRecipe($recipe);
                $sqlError = $this->newCookingStepAction($cookingStep);

                if ($sqlError)
                    return new Response($sqlError);

                $id = $recipe->getId();
                return $this->redirect($this->generateUrl('barra_back_recipe', array('id' => $id)));
            }
        }


        return $this->render('BarraBackBundle:Recipe:recipe.html.twig', array(
            'recipe' => $recipe,
            'recipeIngredients' => $recipeIngredients,
            'cookingSteps'=> $cookingSteps,
            'formIngredient' => $formRecipeIngredient->createView(),
            'formCookingStep' => $formCookingStep->createView()
        ));
    }





    public function newRecipeIngredientAction($recipeIngredient)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($recipeIngredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Recipe relation could not be inserted');
        }
        return null;
    }


    public function newCookingStepAction($cookingStep)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($cookingStep);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Cooking step could not be inserted');
        }
        return null;
    }
}
