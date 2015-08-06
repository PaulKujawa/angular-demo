<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Cooking;
use Barra\BackBundle\Form\Type\CookingType;
use Barra\BackBundle\Form\Type\Update\CookingUpdateType;

use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CookingController extends Controller
{
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeId = $request->request->get('formCookingUpdate')['recipe'];
        $position = $request->request->get('formCookingUpdate')['position'];

        $cooking = $em->getRepository('BarraFrontBundle:Cooking')->findOneBy(array('recipe'=>$recipeId, 'position'=>$position));

        if (!$cooking) {
            $ajaxResponse = array("code"=>404, "message"=>'Not found');
            return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
        }

        $formUpdate = $this->createForm(new CookingUpdateType(), $cooking);
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
        $cooking = $em->getRepository('BarraFrontBundle:Cooking')->findOneBy(array('recipe'=>$recipeId, 'position'=>$position));

        if (!$cooking)
            throw $this->createNotFoundException('Cooking step not found');

        $em->remove($cooking);
        $em->flush();

        $endPos = $em->getRepository('BarraFrontBundle:Cooking')->getHighestPosition($recipeId);
        $steps = $em->getRepository('BarraFrontBundle:Cooking')->changeBetweenPos($recipeId, $position+1, $endPos, -1);

        $recipe = $em->getRepository('BarraFrontBundle:Recipe')->find($recipeId);
        return $this->redirect($this->generateUrl('barra_back_recipeDetail', array('name'=>$recipe->getName())));
    }



    public function swapAction($recipeId, $posBefore, $posAfter)
    {
        $em = $this->getDoctrine()->getManager();
        $swappedEntry = $em->getRepository('BarraFrontBundle:Cooking')->findOneBy(array('recipe'=>$recipeId, 'position'=>$posBefore));
        $swappedEntry->setPosition($posAfter);

        if ($posBefore < $posAfter)
            $steps = $em->getRepository('BarraFrontBundle:Cooking')->changeBetweenPos($recipeId, $posBefore+1, $posAfter, -1);
        else
            $steps = $em->getRepository('BarraFrontBundle:Cooking')->changeBetweenPos($recipeId, $posAfter, $posBefore-1, 1);

        try {
            $em->flush();
            $ajaxResponse = array("code"=>200);
        } catch (\Doctrine\DBAL\DBALException $e) {
            $ajaxResponse = array("code"=>400);
        }
        return new Response(json_encode($ajaxResponse), 200, array('Content-Type'=>'application/json'));
    }
}