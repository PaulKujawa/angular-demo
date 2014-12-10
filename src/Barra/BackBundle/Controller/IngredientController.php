<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Ingredient;
use Barra\BackBundle\Form\Type\IngredientType;
use Barra\BackBundle\Form\Type\IngredientUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IngredientController extends Controller
{
    public function indexAction(Request $request, $paginationActive)
    {
        $ingredient = new Ingredient();
        $formInsert = $this->createForm(new IngredientType(), $ingredient);
        $formInsert->handleRequest($request);

        if ($formInsert->isValid()) {
            $sqlError = $this->newIngredient($ingredient);

            if ($sqlError)
                $formInsert->addError(new FormError($sqlError));
            else
                return $this->redirect($this->generateUrl('barra_back_recipes'));
        }

        $paginationRange = 10;
        $startPos = ($paginationActive-1)*$paginationRange;
        $em = $this->getDoctrine()->getManager();
        $ingredients = $em->getRepository('BarraFrontBundle:Ingredient')->getSome($startPos, $paginationRange);
        $paginationCnt = $em->getRepository('BarraFrontBundle:Ingredient')->count();
        $paginationCnt = ceil($paginationCnt/$paginationRange);
        $formUpdate = $this->createForm(new IngredientUpdateType(), $ingredient);

        return $this->render('BarraBackBundle:Ingredient:ingredients.html.twig', array(
            'paginationActive' => $paginationActive,
            'paginationCnt' => $paginationCnt,
            'ingredients' => $ingredients,
            'formInsert' => $formInsert->createView(),
            'formUpdate' => $formUpdate->createView()
        ));
    }

    public function newIngredient($ingredient)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($ingredient);

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
        $id = $request->request->get('formIngredientUpdate')['id'];
        $ingredient = $em->getRepository('BarraFrontBundle:Ingredient')->find($id);

        if (!$ingredient) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new IngredientUpdateType(), $ingredient);
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
        $ingredient = $em->getRepository('BarraFrontBundle:Ingredient')->find($id);

        if (!$ingredient)
            throw $this->createNotFoundException('Ingredient not found');

        $em->remove($ingredient);
        $em->flush();

        return $this->redirect($this->generateUrl('barra_back_ingredients'));
    }
}