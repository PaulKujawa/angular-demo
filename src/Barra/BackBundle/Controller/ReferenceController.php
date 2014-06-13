<?php

namespace Barra\BackBundle\Controller;

use Barra\FrontBundle\Entity\Reference;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;

class ReferenceController extends Controller
{
    public function indexAction()
    {

       //$this->newReferenceAction("artd webdesign GmbH", "kujawa.de", "internsship", '2014-05-01', '2014-07-01');


        $em = $this->getDoctrine()->getManager();
        $references = $em->getRepository('BarraFrontBundle:Reference')->findAll();

        if (!$references)
            throw $this->createNotFoundException('References not found');

        return $this->render('BarraBackBundle:Reference:references.html.twig', array(
            'references' => $references,
        ));
    }


    public function newReferenceAction($company, $website, $description, $started, $finished)
    {
        $reference = new Reference();
        $reference->setCompany($company)->setWebsite($website)->setDescription($description)
            ->setStarted(new \DateTime($started))->setFinished(new \DateTime($finished));

        $em = $this->getDoctrine()->getManager();
        $em->persist($reference);

        try {
            $em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            return new Response('Reference could not be inserted');
        }

        return new Response('Success! Inserted reference');
    }


    public function updateReference($company, $website, $description, $started, $finished)
    {
        $em = $this->getDoctrine()->getManager();
        $reference = $em->getRepository('BarraFrontBundle:Reference')->findOneBy(array(
                'company'=>$company, 'website'=>$website)
        );
        $reference->setCompany($company)->setWebsite($website)->setDescription($description)
            ->setStarted(new \DateTime($started))->setFinished(new \DateTime($finished));
        $em->flush();
        return new Response('Success! Updated reference');
    }


    public function deleteReferenceAction($company, $website)
    {
        $em = $this->getDoctrine()->getManager();
        $reference = $em->getRepository('BarraFrontBundle:Reference')->findOneBy(array(
            'company'=>$company, 'website'=>$website)
        );

        if (!$reference)
            throw $this->createNotFoundException('Reference not found');

        $em->remove($reference);
        $em->flush();
        return new Response('Success! Deleted reference');
    }
}