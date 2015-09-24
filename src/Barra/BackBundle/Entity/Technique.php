<?php

namespace Barra\BackBundle\Entity;

use Barra\BackBundle\Entity\Traits\DescriptionTrait;
use Barra\BackBundle\Entity\Traits\IdAutoTrait;
use Barra\BackBundle\Entity\Traits\NameTrait;
use Barra\BackBundle\Entity\Traits\UrlTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Technique
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Entity
 *
 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\BackBundle\Entity\Repository\TechniqueRepository")
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
