<?php

namespace Barra\AdminBundle\Entity;

use Barra\AdminBundle\Entity\Traits\IdAutoTrait;
use Barra\AdminBundle\Entity\Traits\NameTrait;
use Barra\AdminBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Screenshot
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity
 *
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity("name")
 * @UniqueEntity("filename")
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity()
 */
class Screenshot
{
    use IdAutoTrait,
        NameTrait,
        ImageTrait
    ;

    /**
     * @var Reference
     *
     * @Assert\NotNull()
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Reference",
     *      inversedBy   = "screenshots"
     * )
     * @ORM\JoinColumn(
     *      name                 = "reference",
     *      referencedColumnName = "id",
     *      nullable             = false,
     *      onDelete             = "CASCADE"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    protected $reference;

    /**
     * @param Reference $reference
     * @return $this
     */
    public function setReference(Reference $reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return Reference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return bool
     */
    public function isRemovable()
    {
        return true;
    }
}
