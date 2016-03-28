<?php

namespace Barra\RecipeBundle\Entity;

use Barra\RecipeBundle\Entity\Traits\IdAutoTrait;
use Barra\RecipeBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ExclusionPolicy("none")
 *
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
     * @Assert\GreaterThan(
     *      value = 0
     * )
     *
     * @ORM\Column(
     *      name = "gr",
     *      type = "smallint"
     * )
     */
    private $gr;

    /**
     * @var ArrayCollection
     *
     * @Exclude
     *
     * @ORM\OneToMany(
     *      targetEntity = "Ingredient",
     *      mappedBy     = "measurement"
     * )
     */
    private $ingredients;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    /**
     * @param int $gr
     * @return $this
     */
    public function setGr($gr)
    {
        $this->gr = $gr;

        return $this;
    }

    /**
     * @return int
     */
    public function getGr()
    {
        return $this->gr;
    }

    /**
     * @param Ingredient $ingredients
     * @return $this
     */
    public function addIngredient(Ingredient $ingredients)
    {
        $this->ingredients[] = $ingredients;

        return $this;
    }

    /**
     * @param Ingredient $ingredients
     * @return $this
     */
    public function removeIngredient(Ingredient $ingredients)
    {
        $this->ingredients->removeElement($ingredients);

        return $this;
    }

    /**
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
