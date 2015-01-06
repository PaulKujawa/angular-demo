<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\FrontBundle\Entity\RecipeRepository")
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=40, unique=true)
     */
    private $name;

    /**
     * @ORM\Column(name="rating", type="smallint")
     */
    private $rating;

    /**
     * @ORM\Column(name="votes", type="integer")
     */
    private $votes;

    /**
     * @ORM\OneToMany(targetEntity="UploadedImage", mappedBy="recipe")
     */
    private $uploadedImages;


    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param integer $rating
     * @return Recipe
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return integer
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param integer $votes
     * @return Recipe
     */
    public function setVotes($votes)
    {
        $this->votes = $votes;

        return $this;
    }

    /**
     * @return integer
     */
    public function getVotes()
    {
        return $this->votes;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->uploadedImages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add uploadedImages
     *
     * @param \Barra\FrontBundle\Entity\UploadedImage $uploadedImages
     * @return Recipe
     */
    public function addUploadedImage(\Barra\FrontBundle\Entity\UploadedImage $uploadedImages)
    {
        $this->uploadedImages[] = $uploadedImages;

        return $this;
    }

    /**
     * Remove uploadedImages
     *
     * @param \Barra\FrontBundle\Entity\UploadedImage $uploadedImages
     */
    public function removeUploadedImage(\Barra\FrontBundle\Entity\UploadedImage $uploadedImages)
    {
        $this->uploadedImages->removeElement($uploadedImages);
    }

    /**
     * Get uploadedImages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUploadedImages()
    {
        return $this->uploadedImages;
    }
}
