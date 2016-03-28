<?php

namespace Barra\RecipeBundle\DataFixtures\ORM;

use Barra\RecipeBundle\Entity\Recipe;
use Barra\RecipeBundle\Entity\Photo;
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

        array_walk(self::$members, function($member, $i) use ($em) {
            $this->addReference('refPhoto' . ($i + 1), $member);
            $em->persist($member);
        });
        $em->flush();

        // file creation doesn't belong to fixtures but is necessary to set up these instances
        // some functional tests however recreate a file themselves
        /** @var Photo $e */
        foreach (self::$members as $e) {
            unlink($e->getAbsolutePathWithFilename());
        }
    }

    /**
     * @param string $refRecipe
     *
     * @return Photo
     */
    protected function instantiate($refRecipe)
    {
        $recipe = $this->getReference($refRecipe);

        if (!$recipe instanceof Recipe) {
            throw new InvalidArgumentException();
        }

        $entity = new Photo();
        $file = $this->simulateUpload($entity);

        $entity
            ->setRecipe($recipe)
            ->setFile($file);

        return $entity;
    }

    /**
     * @param Photo $entity
     *
     * @return UploadedFile
     */
    protected function simulateUpload(Photo $entity)
    {
        $filename = uniqid('tempFile') . '.jpg';
        $newFile = $entity->getAbsolutePath() . '/' . $filename;
        copy($entity->getAbsolutePath() . '/fixture.jpg', $newFile);

        return new UploadedFile(
            $newFile,
            $filename,
            'image/jpeg',
            filesize($newFile),
            null,
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getOrder()
    {
        return 7;
    }
}
