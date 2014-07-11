<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Recipe;
use Barra\BackBundle\Form\Type\RecipeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    public function indexAction(Request $request)
    {
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


        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('BarraFrontBundle:Recipe')->findAll();

        return $this->render('BarraBackBundle:Recipe:recipes.html.twig', array(
            'recipes' => $recipes,
            'form' => $form->createView()
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


    public function deleteRecipeAction($id)
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
