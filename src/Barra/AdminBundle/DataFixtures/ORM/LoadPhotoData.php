<?php

namespace Barra\AdminBundle\DataFixtures\ORM;

use Barra\AdminBundle\Entity\Recipe;
use Barra\AdminBundle\Entity\Photo;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class LoadPhotoData
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\DataFixtures\ORM
 */
class LoadPhotoData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];


    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('Photo1', 'refRecipe1');
        self::$members[] = $this->instantiate('Photo2', 'refRecipe1');
        self::$members[] = $this->instantiate('Photo3', 'refRecipe3');

        foreach (self::$members as $i => $e) {
            $this->addReference('refPhoto'.($i+1), $e);
            $em->persist($e);
        }
        $em->flush();
    }


    /**
     * @param string $name
     * @param string $refRecipe
     * @return Photo
     * @throws InvalidArgumentException
     */
    protected function instantiate($name, $refRecipe)
    {
        $recipe = $this->getReference($refRecipe);

        if (!$recipe instanceof Recipe) {
            throw new InvalidArgumentException();
        }

        $entity = new Photo();
        $file   = $this->simulateUpload($entity, $name);

        $entity
            ->setRecipe($recipe)
            ->setFile($file)
        ;

        return $entity;
    }


    /**
     * @param Photo     $entity
     * @param string    $filename
     * @return UploadedFile
     */
    protected function simulateUpload(Photo $entity, $filename)
    {
        $filename .= 'jpg';
        $newFile   = $entity->getAbsolutePath().'/'.$filename;

        copy($entity->getAbsolutePath().'/fixture.jpg', $newFile);

        // 'receive' uploaded file and instantiate an representing object
        return new UploadedFile(
            $newFile,
            $filename,
            'image/jpeg',
            filesize($newFile),
            null,
            true
        );
    }


    public function getOrder()
    {
        return 7;
    }
}
