<?php

namespace Barra\BackBundle\Entity;

use Barra\BackBundle\Entity\Traits\DescriptionTrait;
use Barra\BackBundle\Entity\Traits\IdAutoTrait;
use Barra\BackBundle\Entity\Traits\ImageTrait;
use Barra\BackBundle\Entity\Traits\UrlTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Reference
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Entity

 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\BackBundle\Entity\Repository\ReferenceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Reference
{
    use IdAutoTrait,
        UrlTrait,
        DescriptionTrait,
        ImageTrait
    ;

    /**
     * @var \DateTime
     * @Assert\NotNull()
     * @ORM\Column(
     *      name        = "started",
     *      type        = "date",
     *      nullable    = false
     * )
     */
    private $started;

    /**
     * @var \DateTime
     * @Assert\NotNull()
     * @ORM\Column(
     *      name        = "finished",
     *      type        = "date",
     *      nullable    = false
     * )
     */
    private $finished;

    /**
     * @var Agency
     * @Assert\NotNull()
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
     * @Assert\NotNull()
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
     *      targetEntity = "Screenshot",
     *      mappedBy     = "reference"
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $screenshots;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->techniques        = new ArrayCollection();
        $this->screenshots = new ArrayCollection();
    }

    /**
     * Set started
     * @param \DateTime $started
     * @return Reference
     */
    public function setStarted(\DateTime $started)
    {
        $this->started = $started;

        return $this;
    }

    /**
     * Get started
     * @return \DateTime
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * Set finished
     * @param \DateTime $finished
     * @return Reference
     */
    public function setFinished(\DateTime $finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get finished
     * @return \DateTime
     */
    public function getFinished()
    {
        return $this->finished;
    }

    /**
     * Set agency
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
     * @return Agency
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Add techniques
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
     * @param Technique $techniques
     * @return $this
     */
    public function removeTechnique(Technique $techniques)
    {
        $this->techniques->removeElement($techniques);

        return $this;
    }

    /**
     * Get techniques
     * @return ArrayCollection
     */
    public function getTechniques()
    {
        return $this->techniques;
    }

    /**
     * Add screenshots
     * @param Screenshot $screenshots
     * @return Reference
     */
    public function addScreenshot(Screenshot $screenshots)
    {
        $this->screenshots[] = $screenshots;

        return $this;
    }

    /**
     * Remove screenshots
     * @param Screenshot $screenshots
     * @return $this
     */
    public function removeScreenshot(Screenshot $screenshots)
    {
        $this->screenshots->removeElement($screenshots);

        return $this;
    }

    /**
     * Get screenshots
     * @return ArrayCollection
     */
    public function getScreenshots()
    {
        return $this->screenshots;
    }
}
