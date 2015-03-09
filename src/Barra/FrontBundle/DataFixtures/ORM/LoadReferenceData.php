<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\Reference;

class LoadReferenceData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new Reference();
        $file = $this->manageFile(1);
        $entity1->setUrl("a.com")->setDescription("a")->setStarted(new \DateTime('NOW'))
            ->setFinished(new \DateTime('NOW'))->setAgency($this->getReference('fixAgency1'))
            ->addTechnique($this->getReference('fixTechnique1'))->setSize(filesize($file))->setFile($file);
        $em->persist($entity1);
        $this->addReference('fixReference1', $entity1);

        $entity2 = new Reference();
        $file = $this->manageFile(2);
        $entity2->setUrl("b.com")->setDescription("b")->setStarted(new \DateTime('NOW'))
            ->setFinished(new \DateTime('NOW'))->setAgency($this->getReference('fixAgency2'))
            ->addTechnique($this->getReference('fixTechnique3'))->setSize(filesize($file))->setFile($file);
        $em->persist($entity2);
        $this->addReference('fixReference2', $entity2);

        $entity3 = new Reference();
        $file = $this->manageFile(3);
        $entity3->setUrl("c.com")->setDescription("c")->setStarted(new \DateTime('NOW'))
            ->setFinished(new \DateTime('NOW'))->setAgency($this->getReference('fixAgency3'))
            ->addTechnique($this->getReference('fixTechnique2'))->setSize(filesize($file))->setFile($file);
        $em->persist($entity3);
        $this->addReference('fixReference3', $entity3);

        $em->flush();
        self::$members = array($entity1, $entity2, $entity3);
    }


    /**
     * @param $i
     * @return UploadedFile
     */
    protected function manageFile($i)
    {
        $path =  __DIR__.'/../../../../../web/uploads/documents/';
        $origFile = $path. 'fixture.jpg';
        $copyFile = $path. 'fixtureCopy' .$i. '.jpg';

        copy($origFile, $copyFile);
        return new UploadedFile($copyFile, "fixtuePicture".$i, null, filesize($copyFile), null, true);
    }


    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 10;
    }
}
