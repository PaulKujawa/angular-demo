<?php

namespace Barra\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cooking
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\DefaultBundle\Entity\CookingRepository")
 */
class Cooking
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
     * @var integer
     *
     * @ORM\Column(name="step", type="smallint", nullable=false)
     */
    private $step;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="Recipe")
     * @ORM\JoinColumn(name="recipe", referencedColumnName="id", nullable=false)
     */
    private $recipe;

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
     * Set step
     *
     * @param integer $step
     * @return Cooking
     */
    public function setStep($step)
    {
        $this->step = $step;

        return $this;
    }

    /**
     * Get step
     *
     * @return integer 
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Cooking
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
}
