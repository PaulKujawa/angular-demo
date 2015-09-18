<?php

namespace Barra\FrontBundle\DataFixtures\ORM;

use Barra\FrontBundle\Entity\Recipe;
use Barra\FrontBundle\Entity\Photo;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class LoadPhotoData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\DataFixtures\ORM
 */
class LoadPhotoData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('Photo1', 'refRecipe1');
        self::$members[] = $this->instantiate('Photo2', 'refRecipe2');
        self::$members[] = $this->instantiate('Photo3', 'refRecipe3');

        foreach (self::$members as $i => $e) {
            $this->addReference('refPhoto'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }


    /**
     * @param string        $name
     * @param string        $refRecipe
     * @return Photo
     */
    protected function instantiate($name, $refRecipe)
    {
        $recipe = $this->getReference($refRecipe);

        if (!$recipe instanceof Recipe ||
            !is_string($name)
        ) {
            throw new InvalidArgumentException();
        }

        $entity = new Photo();
        $entity->setName($name);
        $file = $this->simulateUpload($entity);

        $entity
            ->setRecipe($recipe)
            ->setFile($file)
            ->setSize($file->getClientSize())
        ;

        return $entity;
    }

    /**
     * @param Photo $entity
     * @return UploadedFile
     */
    protected function simulateUpload(Photo $entity)
    {
        // set up demo picture to simulate an upload
        $demoFileName   = $entity->getName().'jpg';
        $demoFile       = $entity->getAbsolutePath().DIRECTORY_SEPARATOR.$demoFileName;

        copy(
            $entity->getAbsolutePath().'/fixture.jpg',
            $demoFile
        );

        // 'receive' uploaded file and instantiate an representing object
        return new UploadedFile(
            $demoFile,
            $demoFileName,
            null,
            filesize($demoFile),
            null,
            true
        );
    }

    public function getOrder()
    {
        return 7;
    }
}
