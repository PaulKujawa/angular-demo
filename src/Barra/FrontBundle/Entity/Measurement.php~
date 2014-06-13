<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Measurement
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Measurement
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=10, unique=true, nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="gr", type="smallint", nullable=false)
     */
    private $gr;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set typ
     *
     * @param string $typ
     * @return Measurement
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get typ
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set gr
     *
     * @param integer $gr
     * @return Measurement
     */
    public function setGr($gr)
    {
        $this->gr = $gr;

        return $this;
    }

    /**
     * Get gr
     *
     * @return integer 
     */
    public function getGr()
    {
        return $this->gr;
    }
}
