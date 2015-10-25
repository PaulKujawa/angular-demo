<?php

namespace Barra\AdminBundle\Entity;

use Barra\AdminBundle\Entity\Traits\DescriptionTrait;
use Barra\AdminBundle\Entity\Traits\IdAutoTrait;
use Barra\AdminBundle\Entity\Traits\NameTrait;
use Barra\AdminBundle\Entity\Traits\UrlTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Technique
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity
 *
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity("name")
 * @UniqueEntity("url")
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\AdminBundle\Entity\Repository\PaginationRepository")
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
     *
     * @ORM\ManyToMany(
     *      targetEntity = "Reference",
     *      mappedBy     = "techniques"
     * )
     * @ORM\OrderBy({"url" = "ASC"})
     */
    private $references;


    public function __construct()
    {
        $this->references = new ArrayCollection();
    }


    /**
     * @param Reference $references
     * @return $this
     */
    public function addReference(Reference $references)
    {
        $this->references[] = $references;

        return $this;
    }


    /**
     * @param Reference $references
     * @return $this
     */
    public function removeReference(Reference $references)
    {
        $this->references->removeElement($references);

        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getReferences()
    {
        return $this->references;
    }


    /**
     * @return bool
     */
    public function isRemovable()
    {
        return $this->getReferences()->isEmpty();
    }
}