<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
/**
 * Recipe
 * @ExclusionPolicy("all")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\FrontBundle\Entity\Repository\RecipeRepository")
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Expose
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=40, unique=true)
     * @Expose
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
     * @ORM\OneToMany(targetEntity="RecipePicture", mappedBy="recipe")
     * @ORM\OrderBy({"title" = "ASC"})
     * @Expose
     */
    private $recipePictures;


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
        $this->recipePictures = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add recipePictures
     *
     * @param \Barra\FrontBundle\Entity\RecipePicture $recipePictures
     * @return Recipe
     */
    public function addRecipePicture(\Barra\FrontBundle\Entity\RecipePicture $recipePictures)
    {
        $this->recipePictures[] = $recipePictures;

        return $this;
    }

    /**
     * Remove recipePictures
     *
     * @param \Barra\FrontBundle\Entity\RecipePicture $recipePictures
     */
    public function removeRecipePicture(\Barra\FrontBundle\Entity\RecipePicture $recipePictures)
    {
        $this->recipePictures->removeElement($recipePictures);
    }

    /**
     * Get recipePictures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecipePictures()
    {
        return $this->recipePictures;
    }
}
