<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Technique
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Technique
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(name="url", type="string", length=30)
     */
    private $url;

    /**
     * @ORM\OneToMany(targetEntity="ReferenceTechnique", mappedBy="technique")
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
     * Set name
     *
     * @param string $name
     * @return Technique
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Technique
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
     * Set url
     *
     * @param string $url
     * @return Technique
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
     * @return Technique
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
}
