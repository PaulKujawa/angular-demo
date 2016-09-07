<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Recipe
{
    use IdAutoTrait;
    use NameTrait;

    /**
     * @var ArrayCollection
     *
     * @Exclude
     *
     * @ORM\OneToMany(
     *      targetEntity = "Ingredient",
     *      mappedBy = "recipe"
     * )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $ingredients;

    /**
     * @var ArrayCollection
     * 
     * @Exclude
     * @ORM\OneToMany(
     *      targetEntity = "Cooking",
     *      mappedBy = "recipe"
     * )
     * @ORM\OrderBy({"position" = "ASC"})
     */
    private $cookings;

    /**
     * @var Photo
     *
     * @ORM\OneToOne(targetEntity = "Photo")
     * @ORM\JoinColumn(
     *      name = "thumbnail",
     *      referencedColumnName = "id"
     * )
     */
    private $thumbnail;

    /**
     * @var ArrayCollection
     *
     * @Exclude
     *
     * @ORM\OneToMany(
     *      targetEntity = "Photo",
     *      mappedBy = "recipe",
     *      cascade = {"remove"}
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $photos;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
        $this->cookings = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
    }

    /**
     * @param Ingredient $ingredients
     *
     * @return $this
     */
    public function addIngredient(Ingredient $ingredients)
    {
        $this->ingredients[] = $ingredients;

        return $this;
    }

    /**
     * @param Ingredient $cooking
     *
     * @return $this
     */
    public function removeIngredient(Ingredient $cooking)
    {
        $this->ingredients->removeElement($cooking);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param Cooking $cooking
     *
     * @return $this
     */
    public function addCooking(Cooking $cooking)
    {
        $this->cookings[] = $cooking;

        return $this;
    }

    /**
     * @param Cooking $cooking
     *
     * @return $this
     */
    public function removeCooking(Cooking $cooking)
    {
        $this->cookings->removeElement($cooking);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCookings()
    {
        return $this->cookings;
    }

    /**
     * @param Photo $photos
     *
     * @return $this
     */
    public function addPhoto(Photo $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * @param Photo $photos
     *
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
     * @return Photo
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @param Photo $thumbnail
     *
     * @return $this
     */
    public function setThumbnail(Photo $thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
}
