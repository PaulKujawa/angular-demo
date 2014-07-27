<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Ingredient;
use Barra\BackBundle\Form\Type\IngredientType;
use Barra\BackBundle\Form\Type\IngredientUpdateType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IngredientController extends Controller
{
    public function indexAction(Request $request)
    {
        $ingredient = new Ingredient();
        $formInsert = $this->createForm(new IngredientType(), $ingredient);
        $formInsert->handleRequest($request);

        if ($formInsert->isValid()) {
            $sqlError = $this->newIngredientAction($ingredient);

            if ($sqlError)
                return new Response($sqlError);
            else
                return $this->redirect($this->generateUrl('barra_back_recipes'));
        }

        $em = $this->getDoctrine()->getManager();
        $ingredients = $em->getRepository('BarraFrontBundle:Ingredient')->findAll();
        $formUpdate = $this->createForm(new IngredientUpdateType(), $ingredient);

        return $this->render('BarraBackBundle:Ingredient:ingredients.html.twig', array(
            'ingredients' => $ingredients,
            'formInsert' => $formInsert->createView(),
            'formUpdate' => $formUpdate->createView()
        ));
    }

    public function newIngredientAction($ingredient)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($ingredient);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Ingredient could not be inserted');
        }
        return null;
    }



    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('formIngredientUpdate')['id'];
        $ingredient = $em->getRepository('BarraFrontBundle:Ingredient')->find($id);

        if (!$ingredient) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new IngredientUpdateType(), $ingredient);
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



    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $ingredient = $em->getRepository('BarraFrontBundle:Ingredient')->find($id);

        if (!$ingredient)
            throw $this->createNotFoundException('Ingredient not found');

        $em->remove($ingredient);
        $em->flush();

        return $this->redirect($this->generateUrl('barra_back_ingredients'));
    }
}