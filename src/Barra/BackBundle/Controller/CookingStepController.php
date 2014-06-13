<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\CookingStep;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CookingStepController extends Controller
{
    public function newCookingStepAction($recipe, $step, $description)
    {
        $cookingStep = new CookingStep();
        $cookingStep->setRecipe($recipe)->setStep($step)->setDescription($description);

        $em = $this->getDoctrine()->getManager();
        $em->persist($cookingStep);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Cooking step could not be inserted');
        }
        return new Response('Success! Inserted cooking step');
    }


    public function updateCookingStep($recipe, $step, $description)
    {
        $em = $this->getDoctrine()->getManager();
        $cooking = $em->getRepository('BarraFrontBundle:CookingStep')->findOneBy(array(
                'recipe'=>$recipe, 'step'=>$step)
        );
        $cooking->setRecipe($recipe)->setStep($step)->setDescription($description);
        $em->flush();
        return new Response('Success! Updated cooking step');
    }


    public function deleteCookingStepAction($recipe, $step)
    {
        $em = $this->getDoctrine()->getManager();
        $cooking = $em->getRepository('BarraFrontBundle:CookingStep')->findOneBy(array(
            'recipe'=>$recipe, 'step'=>$step)
        );

        if (!$cooking)
            throw $this->createNotFoundException('Cooking step not found');

        $em->remove($cooking);
        $em->flush();
        return new Response('Success! Deleted cooking step');
    }
}