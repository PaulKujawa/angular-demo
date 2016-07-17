<?php

namespace AppBundle\Service;

use AppBundle\Entity\Photo;
use Doctrine\ORM\EntityManager;

class PhotoService
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager= $entityManager;
    }

    /**
     * @param int $recipeId
     *
     * @return Photo[]|array
     */
    public function getPhotos($recipeId)
    {
        return $this->entityManager->getRepository(Photo::class)->findBy(['recipe' => $recipeId]);
    }

    /**
     * @param int $recipeId
     * @param int $id
     *
     * @return Photo|null
     */
    public function getPhoto($recipeId, $id)
    {
        return $this->entityManager->getRepository(Photo::class)->findOneBy(['recipe' => $recipeId, 'id' => $id]);
    }

    /**
     * @param Photo $photo
     *
     * @return Photo
     */
    public function addPhoto(Photo $photo)
    {
        $this->entityManager->persist($photo);
        $this->entityManager->flush($photo);

        return $photo;
    }

    /**
     * @param Photo $photo
     */
    public function setPhoto(Photo $photo)
    {
        $this->entityManager->flush($photo);
    }

    /**
     * @param Photo $photo
     */
    public function deletePhoto(Photo $photo)
    {
        $this->entityManager->remove($photo);
        $this->entityManager->flush($photo);
    }
}
