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
     * @ORM\OneToMany(targetEntity="ReferenceTechnique", mappedBy="reference")
     */
    private $referenceTechniques;


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
     * Constructor
     */
    public function __construct()
    {
        $this->referenceTechniques = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add referenceTechniques
     *
     * @param \Barra\FrontBundle\Entity\ReferenceTechnique $referenceTechniques
     * @return Reference
     */
    public function addReferenceTechnique(\Barra\FrontBundle\Entity\ReferenceTechnique $referenceTechniques)
    {
        $this->referenceTechniques[] = $referenceTechniques;

        return $this;
    }

    /**
     * Remove referenceTechniques
     *
     * @param \Barra\FrontBundle\Entity\ReferenceTechnique $referenceTechniques
     */
    public function removeReferenceTechnique(\Barra\FrontBundle\Entity\ReferenceTechnique $referenceTechniques)
    {
        $this->referenceTechniques->removeElement($referenceTechniques);
    }

    /**
     * Get referenceTechniques
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReferenceTechniques()
    {
        return $this->referenceTechniques;
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
}
