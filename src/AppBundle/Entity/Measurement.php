<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Measurement
{
    use IdAutoTrait;
    use NameTrait;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\GreaterThan(value = 0)
     *
     * @ORM\Column(type = "smallint")
     */
    private $gr;

    /**
     * @param int $gr
     */
    public function setGr($gr)
    {
        $this->gr = $gr;
    }

    /**
     * @return int
     */
    public function getGr()
    {
        return $this->gr;
    }
}
