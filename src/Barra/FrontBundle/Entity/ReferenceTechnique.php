<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReferenceTechnique
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ReferenceTechnique
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Reference", inversedBy="referenceTechniques")
     * @ORM\JoinColumn(name="reference", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $reference;


    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Technique", inversedBy="referenceTechniques")
     * @ORM\JoinColumn(name="technique", referencedColumnName="id", nullable=false)
     */
    private $technique;

    /**
     * Set reference
     *
     * @param \Barra\FrontBundle\Entity\Reference $reference
     * @return ReferenceTechnique
     */
    public function setReference(\Barra\FrontBundle\Entity\Reference $reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return \Barra\FrontBundle\Entity\Reference 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set technique
     *
     * @param \Barra\FrontBundle\Entity\Technique $technique
     * @return ReferenceTechnique
     */
    public function setTechnique(\Barra\FrontBundle\Entity\Technique $technique)
    {
        $this->technique = $technique;

        return $this;
    }

    /**
     * Get technique
     *
     * @return \Barra\FrontBundle\Entity\Technique 
     */
    public function getTechnique()
    {
        return $this->technique;
    }
}
