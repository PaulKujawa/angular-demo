<?php

namespace Barra\AdminBundle\Entity;

use Barra\AdminBundle\Entity\Traits\DescriptionTrait;
use Barra\AdminBundle\Entity\Traits\IdAutoTrait;
use Barra\AdminBundle\Entity\Traits\ImageTrait;
use Barra\AdminBundle\Entity\Traits\UrlTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Reference
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity

 * @ExclusionPolicy("none")
 *
 * @UniqueEntity("url")
 * @UniqueEntity("filename")
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass = "Barra\AdminBundle\Entity\Repository\PaginationRepository")
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
     *
     * @Assert\NotNull()
     * @Assert\DateTime()
     *
     * @ORM\Column(
     *      name        = "started",
     *      type        = "date",
     *      nullable    = false
     * )
     */
    private $started;

    /**
     * @var \DateTime
     *
     * @Assert\NotNull()
     * @Assert\DateTime()
     *
     * @ORM\Column(
     *      name        = "finished",
     *      type        = "date",
     *      nullable    = false
     * )
     */
    private $finished;

    /**
     * @var Agency
     *
     * @Assert\NotNull()
     *
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
     *
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
     *
     * @ORM\OneToMany(
     *      targetEntity = "Screenshot",
     *      mappedBy     = "reference",
     *      cascade      = {"remove"}
     * )
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $screenshots;


    public function __construct()
    {
        $this->techniques  = new ArrayCollection();
        $this->screenshots = new ArrayCollection();
    }


    /**
     * @param \DateTime $started
     * @return $this
     */
    public function setStarted(\DateTime $started)
    {
        $this->started = $started;

        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getStarted()
    {
        return $this->started;
    }


    /**
     * @param \DateTime $finished
     * @return $this
     */
    public function setFinished(\DateTime $finished)
    {
        $this->finished = $finished;

        return $this;
    }


    /**
     * @return \DateTime
     */
    public function getFinished()
    {
        return $this->finished;
    }


    /**
     * @param Agency $agency
     * @return $this
     */
    public function setAgency(Agency $agency)
    {
        $this->agency = $agency;

        return $this;
    }


    /**
     * @return Agency
     */
    public function getAgency()
    {
        return $this->agency;
    }


    /**
     * @param Technique $techniques
     * @return $this
     */
    public function addTechnique(Technique $techniques)
    {
        $this->techniques[] = $techniques;

        return $this;
    }


    /**
     * @param Technique $techniques
     * @return $this
     */
    public function removeTechnique(Technique $techniques)
    {
        $this->techniques->removeElement($techniques);

        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getTechniques()
    {
        return $this->techniques;
    }


    /**
     * @param Screenshot $screenshots
     * @return $this
     */
    public function addScreenshot(Screenshot $screenshots)
    {
        $this->screenshots[] = $screenshots;

        return $this;
    }


    /**
     * @param Screenshot $screenshots
     * @return $this
     */
    public function removeScreenshot(Screenshot $screenshots)
    {
        $this->screenshots->removeElement($screenshots);

        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getScreenshots()
    {
        return $this->screenshots;
    }


    /**
     * @return bool
     */
    public function isRemovable()
    {
        return true;
    }
}
