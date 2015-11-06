<?php

namespace Barra\AdminBundle\Entity;

use Barra\AdminBundle\Entity\Traits\IdAutoTrait;
use Barra\AdminBundle\Entity\Traits\NameTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Measurement
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity

 * @ExclusionPolicy("none")
 *
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\AdminBundle\Entity\Repository\BasicRepository")
 */
class Measurement
{
    use IdAutoTrait,
        NameTrait
    ;

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
