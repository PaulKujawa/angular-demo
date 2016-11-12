<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Recipe;
use AppBundle\Entity\Photo;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadPhotoData extends AbstractFixture implements OrderedFixtureInterface
{
    static public $members = [];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $em)
    {
        self::$members[] = $this->instantiate('refRecipe1');
        self::$members[] = $this->instantiate('refRecipe1');
        self::$members[] = $this->instantiate('refRecipe3');

        array_walk(self::$members, function(Photo $photo, $i) use ($em) {
            unlink($photo->getAbsolutePathWithFilename());
            $this->addReference('refPhoto' . ($i + 1), $photo);
            $em->persist($photo);
        });
        $em->flush();
    }

    /**
     * @param string $refRecipe
     *
     * @return Photo
     */
    private function instantiate($refRecipe)
    {
        $recipe = $this->getReference($refRecipe);

        if (!$recipe instanceof Recipe) {
            throw new InvalidArgumentException();
        }

        $photo = new Photo($recipe->getId());
        $file = $this->simulateUpload($photo);
        $photo->setFile($file);

        return $photo;
    }

    /**
     * @param Photo $entity
     *
     * @return UploadedFile
     */
    private function simulateUpload(Photo $entity)
    {
        $filename = uniqid('tempFile') . '.jpg';
        $newFile = $entity->getAbsolutePath() . '/' . $filename;
        copy($entity->getAbsolutePath() . '/fixture.jpg', $newFile);

        return new UploadedFile($newFile, $filename, 'image/jpeg', filesize($newFile), null, true);
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 7;
    }
}
