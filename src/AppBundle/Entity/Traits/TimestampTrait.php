<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function setUpdated()
    {
        $this->updated = new DateTime();
    }
}
