<?php

namespace Barra\AdminBundle\Entity;

use Barra\AdminBundle\Entity\Traits\IdAutoTrait;
use Barra\AdminBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Recipe
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity
 *
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\AdminBundle\Entity\Repository\PaginationRepository")
 */
class Recipe
{
    use IdAutoTrait,
        NameTrait
    ;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity = "Photo",
     *      mappedBy     = "recipe",
     *      cascade      = {"remove"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $photos;


    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }


    /**
     * @param Photo $photos
     * @return $this
     */
    public function addPhoto(Photo $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }


    /**
     * @param Photo $photos
     * @return $this
     */
    public function removePhoto(Photo $photos)
    {
        $this->photos->removeElement($photos);

        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getPhotos()
    {
        return $this->photos;
    }


    /**
     * @return bool
     */
    public function isRemovable()
    {
        return true;
    }
}
