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
    /**
     * @var Photo[]
     */
    static public $members = [];

    public function load(ObjectManager $em): void
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

    private function instantiate(string $refRecipe): Photo
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

    private function simulateUpload(Photo $entity): UploadedFile
    {
        $filename = uniqid('tempFile') . '.jpg';
        $newFile = $entity->getAbsolutePath() . '/' . $filename;
        copy($entity->getAbsolutePath() . '/fixture.jpg', $newFile);

        return new UploadedFile($newFile, $filename, 'image/jpeg', filesize($newFile), null, true);
    }

    public function getOrder(): int
    {
        return 7;
    }
}
