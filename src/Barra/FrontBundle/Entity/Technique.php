<?php

namespace Barra\FrontBundle\Entity;

use Barra\FrontBundle\Entity\Traits\DescriptionTrait;
use Barra\FrontBundle\Entity\Traits\IdAutoTrait;
use Barra\FrontBundle\Entity\Traits\NameTrait;
use Barra\FrontBundle\Entity\Traits\UrlTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Technique
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity
 *
 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\FrontBundle\Entity\Repository\TechniqueRepository")
 */
class Technique
{
    use IdAutoTrait,
        NameTrait,
        DescriptionTrait,
        UrlTrait
    ;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(
     *      targetEntity = "Reference",
     *      mappedBy     = "techniques"
     * )
     * @ORM\OrderBy({"url" = "ASC"})
     */
    private $references;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->references = new ArrayCollection();
    }


    /**
     * Add references
     * @param Reference $references
     * @return $this
     */
    public function addReference(Reference $references)
    {
        $this->references[] = $references;

        return $this;
    }

    /**
     * Remove references
     * @param Reference $references
     * @return $this
     */
    public function removeReference(Reference $references)
    {
        $this->references->removeElement($references);

        return $this;
    }

    /**
     * Get references
     * @return ArrayCollection
     */
    public function getReferences()
    {
        return $this->references;
    }
}
