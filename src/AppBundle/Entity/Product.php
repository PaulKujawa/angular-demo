<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\NameTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @UniqueEntity("name")
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Product
{
    use IdAutoTrait;
    use NameTrait;

    /**
     * @var bool
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(
     *      name = "vegan",
     *      type = "boolean"
     * )
     */
    private $vegan;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\GreaterThan(value = 0)
     *
     * @ORM\Column(
     *      name = "gr",
     *      type = "smallint"
     * )
     */
    private $gr;

    /**
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\GreaterThan(value = 0)
     *
     * @ORM\Column(
     *      name = "kcal",
     *      type = "integer"
     * )
     */
    private $kcal;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      name = "protein",
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $protein;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      name = "carbs",
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $carbs;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      name = "sugar",
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $sugar;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      name = "fat",
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $fat;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
     *      name = "gfat",
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $gfat;

    /**
     * @var Manufacturer
     *
     * @Assert\NotNull()
     *
     * @Serializer\Exclude()
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Manufacturer",
     *      inversedBy = "products"
     * )
     * @ORM\JoinColumn(
     *      name = "manufacturer",
     *      referencedColumnName = "id",
     *      nullable = false
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $manufacturer;

    /**
     * @param boolean $vegan
     */
    public function setVegan($vegan)
    {
        $this->vegan = $vegan;
    }

    /**
     * @return boolean
     */
    public function getVegan()
    {
        return $this->vegan;
    }


    /**
     * @param int $kcal
     */
    public function setKcal($kcal)
    {
        $this->kcal = $kcal;
    }

    /**
     * @return string
     */
    public function getKcal()
    {
        return $this->kcal;
    }

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

    /**
     * @param double $protein
     */
    public function setProtein($protein)
    {
        $this->protein = $protein;
    }

    /**
     * @return double
     */
    public function getProtein()
    {
        return $this->protein;
    }

    /**
     * @param double $carbs
     */
    public function setCarbs($carbs)
    {
        $this->carbs = $carbs;
    }

    /**
     * @return double
     */
    public function getCarbs()
    {
        return $this->carbs;
    }

    /**
     * @param double $sugar
     */
    public function setSugar($sugar)
    {
        $this->sugar = $sugar;
    }

    /**
     * @return string
     */
    public function getSugar()
    {
        return $this->sugar;
    }

    /**
     * @param double $fat
     */
    public function setFat($fat)
    {
        $this->fat = $fat;
    }

    /**
     * @return double
     */
    public function getFat()
    {
        return $this->fat;
    }

    /**
     * @param double $gfat
     */
    public function setGfat($gfat)
    {
        $this->gfat = $gfat;
    }

    /**
     * @return double
     */
    public function getGfat()
    {
        return $this->gfat;
    }

    /**
     * @param Manufacturer $manufacturer
     */
    public function setManufacturer(Manufacturer $manufacturer)
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return Manufacturer
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }
}
