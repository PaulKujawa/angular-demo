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
     * @ORM\Column(type = "boolean")
     */
    private $vegan;

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
     * @var int
     *
     * @Assert\NotNull()
     * @Assert\GreaterThan(value = 0)
     *
     * @ORM\Column(type = "integer")
     */
    private $kcal;

    /**
     * @var double
     *
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(value = 0.0)
     *
     * @ORM\Column(
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
     *      type = "decimal",
     *      scale = 1
     * )
     */
    private $gfat;

    /**
     * @var string
     *
     * @Assert\Length(max = 40)
     *
     * @ORM\Column(
     *     type = "string",
     *     length = 40
     * )
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
     * @param string $manufacturer
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }
}
