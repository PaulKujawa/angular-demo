<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\CookingStep;
use Barra\BackBundle\Form\Type\CookingStepType;
use Barra\BackBundle\Form\Type\Update\CookingStepUpdateType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CookingStepController extends Controller
{
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeId = $request->request->get('formCookingStepUpdate')['recipe'];
        $position = $request->request->get('formCookingStepUpdate')['position'];

        $cookingStep = $em->getRepository('BarraFrontBundle:CookingStep')->findOneBy(array('recipe'=>$recipeId, 'position'=>$position));

        if (!$cookingStep) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new CookingStepUpdateType(), $cookingStep);
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



    public function deleteAction($recipeId, $position)
    {
        $em = $this->getDoctrine()->getManager();
        $cooking = $em->getRepository('BarraFrontBundle:CookingStep')->findOneBy(array('recipe'=>$recipeId, 'position'=>$position));

        if (!$cooking)
            throw $this->createNotFoundException('Cooking step not found');

        $em->remove($cooking);
        $em->flush();

        $endPos = $em->getRepository('BarraFrontBundle:CookingStep')->getHighestPosition($recipeId);
        $steps = $em->getRepository('BarraFrontBundle:CookingStep')->changeBetweenPos($recipeId, $position+1, $endPos, -1);

        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);
        return $this->redirect($this->generateUrl('barra_back_recipeDetail', array('name'=>$recipe->getName())));
    }



    public function swapAction($recipeId, $posBefore, $posAfter)
    {
        $em = $this->getDoctrine()->getManager();
        $swappedEntry = $em->getRepository('BarraFrontBundle:CookingStep')->findOneBy(array('recipe'=>$recipeId, 'position'=>$posBefore));
        $swappedEntry->setPosition($posAfter);

        if ($posBefore < $posAfter)
            $steps = $em->getRepository('BarraFrontBundle:CookingStep')->changeBetweenPos($recipeId, $posBefore+1, $posAfter, -1);
        else
            $steps = $em->getRepository('BarraFrontBundle:CookingStep')->changeBetweenPos($recipeId, $posAfter, $posBefore-1, 1);

        try {
            $em->flush();
            $ajaxResponse = array("code"=>200);
        } catch (\Doctrine\DBAL\DBALException $e) {
            $ajaxResponse = array("code"=>400);
        }
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }
}