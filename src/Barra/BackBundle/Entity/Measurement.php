<?php

namespace Barra\BackBundle\Entity;

use Barra\BackBundle\Entity\Traits\IdAutoTrait;
use Barra\BackBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Measurement
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Entity

 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\BackBundle\Entity\Repository\MeasurementRepository")
 */
class Measurement
{
    use IdAutoTrait,
        NameTrait
    ;

    /**
     * @var int
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(
     *      value = 1
     * )
     * @ORM\Column(
     *      name = "gr",
     *      type = "smallint"
     * )
     */
    private $gr;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(
     *      targetEntity = "Ingredient",
     *      mappedBy     = "measurement"
     * )
     */
    private $ingredients;

    /**
     * Set gr
     * @param int $gr
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setGr($gr)
    {
        if (!is_int($gr)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'gr',
                'int'
            ));
        }
        $this->gr = $gr;

        return $this;
    }

    /**
     * Get gr
     * @return int
     */
    public function getGr()
    {
        return $this->gr;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    /**
     * Add ingredients
     * @param Ingredient $ingredients
     * @return $this
     */
    public function addIngredient(Ingredient $ingredients)
    {
        $this->ingredients[] = $ingredients;

        return $this;
    }

    /**
     * Remove ingredients
     * @param Ingredient $ingredients
     * @return $this
     */
    public function removeIngredient(Ingredient $ingredients)
    {
        $this->ingredients->removeElement($ingredients);

        return $this;
    }

    /**
     * Get ingredients
     * @return ArrayCollection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @return bool
     */
    public function isRemovable()
    {
        return $this->getIngredients()->isEmpty();
    }
}
