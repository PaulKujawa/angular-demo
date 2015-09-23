<?php

namespace Barra\FrontBundle\Entity;

use Barra\FrontBundle\Entity\Traits\IdAutoTrait;
use Barra\FrontBundle\Entity\Traits\NameTrait;
use Barra\FrontBundle\Entity\Traits\PictureTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * Class Screenshot
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity
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
        PictureTrait
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
}
