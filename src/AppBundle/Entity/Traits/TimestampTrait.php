<?php

namespace AppBundle\Entity\Traits;

use DateTime;

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
     * @Orm\PrePersist()
     */
    public function setCreated()
    {
        $this->created = new DateTime();
    }

    /**
     * @Orm\PrePersist()
     * @Orm\PreUpdate()
     */
    public function setUpdated()
    {
        $this->updated = new DateTime();
    }
}
