<?php

namespace Barra\BackBundle\Entity;

use Barra\BackBundle\Entity\Traits\IdAutoTrait;
use Barra\BackBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Recipe
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Entity
 *
 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\BackBundle\Entity\Repository\RecipeRepository")
 */
class Recipe
{
    use IdAutoTrait,
        NameTrait
    ;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *      targetEntity = "Photo",
     *      mappedBy     = "recipe",
     *      cascade      = {"remove"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $photos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new ArrayCollection();
    }

    /**
     * Add photos
     * @param Photo $photos
     * @return $this
     */
    public function addPhoto(Photo $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     * @param Photo $photos
     * @return $this
     */
    public function removePhoto(Photo $photos)
    {
        $this->photos->removeElement($photos);

        return $this;
    }

    /**
     * Get photos
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
