<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\CookingStep;
use Barra\BackBundle\Form\Type\CookingStepType;
use Barra\FrontBundle\Entity\Recipe;
use Barra\FrontBundle\Entity\RecipeIngredient;
use Barra\BackBundle\Form\Type\RecipeIngredientType;

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
        $formRecipeIngredient = $this->createForm(new RecipeIngredientType(), $recipeIngredient);

        $cookingStep = new CookingStep();
        $formCookingStep = $this->createForm(new CookingStepType(), $cookingStep);


        if ($request->getMethod() === 'POST') {
            if ($request->request->has($formRecipeIngredient->getName())) {
                $formRecipeIngredient->handleRequest($request);
                if ($formRecipeIngredient->isValid()) {
                    $recipeIngredient->setRecipe($recipe)->setPosition(1);
                    $sqlError = $this->newRecipeIngredientAction($recipeIngredient);
                }
            } elseif ($request->request->has($formCookingStep->getName())) {
                $formCookingStep->handleRequest($request);
                if ($formCookingStep->isValid()) {
                    $cookingStep->setRecipe($recipe);
                    $sqlError = $this->newCookingStepAction($cookingStep);
                }
            }

            if ($sqlError)
                return new Response($sqlError);
            return $this->redirect($this->generateUrl('barra_back_recipe', array('name' => $name)));
        }

        return $this->render('BarraBackBundle:Recipe:recipeDetail.html.twig', array(
            'recipe' => $recipe,
            'cookingSteps'=> $cookingSteps,
            'recipeIngredients'=>$recipeIngredients,
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
