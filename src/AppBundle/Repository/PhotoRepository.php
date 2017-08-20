<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Photo;
use Doctrine\ORM\EntityManager;

class PhotoRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager= $entityManager;
    }

    /**
     * @param int $recipeId
     *
     * @return Photo[]|array
     */
    public function getPhotos(int $recipeId): array
    {
        return $this->entityManager->getRepository(Photo::class)->findBy(['recipe' => $recipeId]);
    }

    public function getPhoto(int $recipeId, int $id): ?Photo
    {
        return $this->entityManager->getRepository(Photo::class)->findOneBy(['recipe' => $recipeId, 'id' => $id]);
    }

    public function addPhoto(Photo $photo): Photo
    {
        $this->entityManager->persist($photo);
        $this->entityManager->flush($photo);

        return $photo;
    }

    public function setPhoto(Photo $photo): void
    {
        $this->entityManager->flush($photo);
    }

    public function deletePhoto(Photo $photo): void
    {
        $this->entityManager->remove($photo);
        $this->entityManager->flush($photo);
    }
}
