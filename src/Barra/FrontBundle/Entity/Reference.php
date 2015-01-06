<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reference
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Reference
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="url", type="string", length=30, unique=true)
     */
    private $url;

    /**
     * @ORM\Column(name="description", type="string", length=30)
     */
    private $description;

    /**
     * @ORM\Column(name="started", type="date")
     */
    private $started;

    /**
     * @ORM\Column(name="finished", type="date")
     */
    private $finished;

    /**
     * @ORM\ManyToOne(targetEntity="Agency")
     * @ORM\JoinColumn(name="agency", referencedColumnName="id", nullable=false)
     */
    private $agency;

    /**
     * @ORM\ManyToMany(targetEntity="Technique", mappedBy="references")
     */
    private $techniques;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->techniques = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Reference
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Reference
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
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
     * @param \Barra\FrontBundle\Entity\Agency $agency
     * @return Reference
     */
    public function setAgency(\Barra\FrontBundle\Entity\Agency $agency)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return \Barra\FrontBundle\Entity\Agency 
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Add techniques
     *
     * @param \Barra\FrontBundle\Entity\Technique $techniques
     * @return Reference
     */
    public function addTechnique(\Barra\FrontBundle\Entity\Technique $techniques)
    {
        $this->techniques[] = $techniques;

        return $this;
    }

    /**
     * Remove techniques
     *
     * @param \Barra\FrontBundle\Entity\Technique $techniques
     */
    public function removeTechnique(\Barra\FrontBundle\Entity\Technique $techniques)
    {
        $this->techniques->removeElement($techniques);
    }

    /**
     * Get techniques
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTechniques()
    {
        return $this->techniques;
    }
}
