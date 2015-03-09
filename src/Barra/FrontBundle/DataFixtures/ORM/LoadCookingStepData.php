<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\CookingStep;

class LoadCookingStepData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new CookingStep();
        $entity1->setPosition(1)->setDescription("1st step")->setRecipe( $this->getReference('fixRecipe1') );
        $em->persist($entity1);
        $this->addReference('fixCookingStep1', $entity1);

        $entity2 = new CookingStep();
        $entity2->setPosition(2)->setDescription("2nd step")->setRecipe( $this->getReference('fixRecipe1') );
        $em->persist($entity2);
        $this->addReference('fixCookingStep2', $entity2);

        $entity3 = new CookingStep();
        $entity3->setPosition(3)->setDescription("3th step")->setRecipe( $this->getReference('fixRecipe1') );
        $em->persist($entity3);
        $this->addReference('fixCookingStep3', $entity3);




        $entity4 = new CookingStep();
        $entity4->setPosition(1)->setDescription("1st step")->setRecipe( $this->getReference('fixRecipe2') );
        $em->persist($entity4);
        $this->addReference('fixCookingStep4', $entity4);

        $entity5 = new CookingStep();
        $entity5->setPosition(2)->setDescription("2nd step")->setRecipe( $this->getReference('fixRecipe2') );
        $em->persist($entity5);
        $this->addReference('fixCookingStep5', $entity5);

        $entity6 = new CookingStep();
        $entity6->setPosition(3)->setDescription("3th step")->setRecipe( $this->getReference('fixRecipe2') );
        $em->persist($entity6);
        $this->addReference('fixCookingStep6', $entity6);




        $entity7 = new CookingStep();
        $entity7->setPosition(1)->setDescription("1st step")->setRecipe( $this->getReference('fixRecipe3') );
        $em->persist($entity7);
        $this->addReference('fixCookingStep7', $entity7);

        $entity8 = new CookingStep();
        $entity8->setPosition(2)->setDescription("2nd step")->setRecipe( $this->getReference('fixRecipe3') );
        $em->persist($entity8);
        $this->addReference('fixCookingStep8', $entity8);

        $entity9 = new CookingStep();
        $entity9->setPosition(3)->setDescription("3th step")->setRecipe( $this->getReference('fixRecipe3') );
        $em->persist($entity9);
        $this->addReference('fixCookingStep9', $entity9);

        $em->flush();
        self::$members = array($entity1, $entity2, $entity3, $entity4, $entity5, $entity6, $entity7, $entity8, $entity9);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 6;
    }
}
