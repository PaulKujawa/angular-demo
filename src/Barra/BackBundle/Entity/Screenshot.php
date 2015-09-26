<?php

namespace Barra\BackBundle\Entity;

use Barra\BackBundle\Entity\Traits\IdAutoTrait;
use Barra\BackBundle\Entity\Traits\NameTrait;
use Barra\BackBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Screenshot
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Entity
 *
 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class Screenshot
{
    use IdAutoTrait,
        NameTrait,
        ImageTrait
    ;

    /**
     * @var Reference
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
     * Set reference
     * @param Reference $reference
     * @return $this
     */
    public function setReference(Reference $reference)
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * Get reference
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
