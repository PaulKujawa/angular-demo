<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * TODO expose only for Recipe
 */
trait TimestampTrait
{
    /**
     * @var DateTime
     *
     * @ORM\Column(type = "datetime")
     */
    private $created;

    /**
     * @var DateTime
     *
     * @ORM\Column(type = "datetime")
     */
    private $updated;

    /**
     * @ORM\PrePersist()
     */
    public function setCreated()
    {
        $this->created = new DateTime();
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdated()
    {
        $this->updated = new DateTime();
    }
}
