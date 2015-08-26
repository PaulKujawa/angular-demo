<?php

namespace Barra\FrontBundle\Entity;

use Barra\FrontBundle\Entity\Traits\DescriptionTrait;
use Barra\FrontBundle\Entity\Traits\IdAutoTrait;
use Barra\FrontBundle\Entity\Traits\NameTrait;
use Barra\FrontBundle\Entity\Traits\PictureTrait;
use Barra\FrontBundle\Entity\Traits\UrlTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;

/**
 * Class Reference
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity

 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\FrontBundle\Entity\Repository\ReferenceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Reference
{
    use IdAutoTrait,
        UrlTrait,
        DescriptionTrait,
        PictureTrait
    ;

    /**
     * @var \DateTime
     * @ORM\Column(
     *      name        = "started",
     *      type        = "date",
     *      nullable    = false
     * )
     */
    private $started;

    /**
     * @var \DateTime
     * @ORM\Column(
     *      name        = "finished",
     *      type        = "date",
     *      nullable    = false
     * )
     */
    private $finished;

    /**
     * @var Agency
     * @ORM\ManyToOne(
     *      targetEntity = "Agency",
     *      inversedBy   = "references"
     * )
     * @ORM\JoinColumn(
     *      name                 = "agency",
     *      referencedColumnName = "id",
     *      nullable             = false
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $agency;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(
     *      targetEntity = "Technique",
     *      inversedBy   = "references")
     * @ORM\JoinTable(
     *      name = "ReferenceTechnique"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $techniques;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *      targetEntity = "ReferencePicture",
     *      mappedBy     = "reference"
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $referencePictures;






    /**
     * Constructor
     */
    public function __construct()
    {
        $this->techniques = new ArrayCollection();
    }

    /**
     * Set started
     *
     * @param \DateTime $started
     * @return Reference
     */
    public function setStarted($started)
    {
        $this->started = $started;

        return $this;
    }

    /**
     * Get started
     *
     * @return \DateTime 
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * Set finished
     *
     * @param \DateTime $finished
     * @return Reference
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get finished
     *
     * @return \DateTime 
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * Set agency
     *
     * @param Agency $agency
     * @return Reference
     */
    public function setAgency(Agency $agency)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return Agency
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Add techniques
     *
     * @param Technique $techniques
     * @return Reference
     */
    public function addTechnique(Technique $techniques)
    {
        $this->techniques[] = $techniques;

        return $this;
    }

    /**
     * Remove techniques
     *
     * @param Technique $techniques
     */
    public function removeTechnique(Technique $techniques)
    {
        $this->techniques->removeElement($techniques);
    }

    /**
     * Get techniques
     *
     * @return ArrayCollection
     */
    public function getTechniques()
    {
        return $this->techniques;
    }

    /**
     * Add referencePictures
     *
     * @param ReferencePicture $referencePictures
     * @return Reference
     */
    public function addReferencePicture(ReferencePicture $referencePictures)
    {
        $this->referencePictures[] = $referencePictures;

        return $this;
    }

    /**
     * Remove referencePictures
     *
     * @param ReferencePicture $referencePictures
     */
    public function removeReferencePicture(ReferencePicture $referencePictures)
    {
        $this->referencePictures->removeElement($referencePictures);
    }

    /**
     * Get referencePictures
     *
     * @return ArrayCollection
     */
    public function getReferencePictures()
    {
        return $this->referencePictures;
    }
}
