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
     * @ORM\Column(name="typ", type="string", length=10, unique=true, nullable=false)
     */
    private $typ;

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
    public function setTyp($typ)
    {
        $this->typ = $typ;

        return $this;
    }

    /**
     * Get typ
     *
     * @return string 
     */
    public function getTyp()
    {
        return $this->typ;
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
