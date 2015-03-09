<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Barra\FrontBundle\Entity\ReferencePicture;

class LoadReferencePictureData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = array();

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $entity1 = new ReferencePicture();
        $file = $this->manageFile(1);
        $entity1->setTitle("fixReferencePicture1")->setReference( $this->getReference('fixReference1') )->setSize(filesize($file))->setFile($file);
        $em->persist($entity1);
        $this->addReference('fixReferencePicture1', $entity1);

        $entity2 = new ReferencePicture();
        $file = $this->manageFile(2);
        $entity2->setTitle("fixReferencePicture2")->setReference( $this->getReference('fixReference2') )->setSize(filesize($file))->setFile($file);
        $em->persist($entity2);
        $this->addReference('fixReferencePicture2', $entity2);

        $entity3 = new ReferencePicture();
        $file = $this->manageFile(3);
        $entity3->setTitle("fixReferencePicture3")->setReference( $this->getReference('fixReference3') )->setSize(filesize($file))->setFile($file);
        $em->persist($entity3);
        $this->addReference('fixReferencePicture3', $entity3);

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
        return 11;
    }
}


