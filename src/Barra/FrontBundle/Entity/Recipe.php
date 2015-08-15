<?php

namespace Barra\FrontBundle\Entity;

use Barra\FrontBundle\Entity\Traits\IdAutoTrait;
use Barra\FrontBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Recipe
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity
 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\FrontBundle\Entity\Repository\RecipeRepository")
 */
class Recipe
{
    use NameTrait;
    use IdAutoTrait;

    /**
     * @ORM\OneToMany(
     *      targetEntity = "RecipePicture",
     *      mappedBy     = "recipe"
     * )
     * @ORM\OrderBy({"title" = "ASC"})
     */
    private $recipePictures;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->recipePictures = new ArrayCollection();
    }

    /**
     * Add recipePictures
     *
     * @param RecipePicture $recipePictures
     * @return Recipe
     */
    public function addRecipePicture(RecipePicture $recipePictures)
    {
        $this->recipePictures[] = $recipePictures;

        return $this;
    }

    /**
     * Remove recipePictures
     *
     * @param RecipePicture $recipePictures
     */
    public function removeRecipePicture(RecipePicture $recipePictures)
    {
        $this->recipePictures->removeElement($recipePictures);
    }

    /**
     * Get recipePictures
     *
     * @return ArrayCollection
     */
    public function getRecipePictures()
    {
        return $this->recipePictures;
    }
}
