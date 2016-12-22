<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\TimestampTrait;
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
    use TimestampTrait;

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
     * @var float
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
     * @var float
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
     * @var float
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
     * @var float
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
     * @var float
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
    public function setVegan(bool $vegan)
    {
        $this->vegan = $vegan;
    }

    /**
     * @return boolean
     */
    public function getVegan(): bool
    {
        return $this->vegan;
    }


    /**
     * @param int $kcal
     */
    public function setKcal(int $kcal)
    {
        $this->kcal = $kcal;
    }

    /**
     * @return int
     */
    public function getKcal(): int
    {
        return $this->kcal;
    }

    /**
     * @param int $gr
     */
    public function setGr(int $gr)
    {
        $this->gr = $gr;
    }

    /**
     * @return int
     */
    public function getGr(): int
    {
        return $this->gr;
    }

    /**
     * @param float $protein
     */
    public function setProtein(float $protein)
    {
        $this->protein = $protein;
    }

    /**
     * @return float
     */
    public function getProtein(): float
    {
        return $this->protein;
    }

    /**
     * @param float $carbs
     */
    public function setCarbs(float $carbs)
    {
        $this->carbs = $carbs;
    }

    /**
     * @return float
     */
    public function getCarbs(): float
    {
        return $this->carbs;
    }

    /**
     * @param float $sugar
     */
    public function setSugar(float $sugar)
    {
        $this->sugar = $sugar;
    }

    /**
     * @return float
     */
    public function getSugar(): float
    {
        return $this->sugar;
    }

    /**
     * @param float $fat
     */
    public function setFat(float $fat)
    {
        $this->fat = $fat;
    }

    /**
     * @return float
     */
    public function getFat(): float
    {
        return $this->fat;
    }

    /**
     * @param float $gfat
     */
    public function setGfat(float $gfat)
    {
        $this->gfat = $gfat;
    }

    /**
     * @return float
     */
    public function getGfat(): float
    {
        return $this->gfat;
    }

    /**
     * @param string $manufacturer
     */
    public function setManufacturer(string $manufacturer)
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return string
     */
    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }
}
