<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Barra\BackBundle\Form\Type\RecipeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipesController extends Controller
{
    public function indexAction(Request $request)
    {
        // Form
        $recipe = new Recipe();
        $form = $this->createForm(new RecipeType(), $recipe);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $recipe->setRating(50)->setVotes(2);
            $sqlError = $this->newRecipeAction($recipe);

            if ($sqlError)
                return new Response($sqlError);

            $id = $recipe->getId();
            return $this->redirect($this->generateUrl('barra_back_recipe', array('id' => $id)));
        }

        // Overview
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('BarraFrontBundle:Recipe')->findAll();

        return $this->render('BarraBackBundle:Recipe:recipes.html.twig', array(
            'recipes' => $recipes,
            'formNew' => $form->createView()
        ));
    }


    public function newRecipeAction($recipe)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Recipe could not be inserted');
        }
        return null;
    }
}
