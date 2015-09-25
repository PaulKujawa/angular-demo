<?php

namespace Barra\BackBundle\Entity;

use Barra\BackBundle\Entity\Traits\IdAutoTrait;
use Barra\BackBundle\Entity\Traits\NameTrait;
use Barra\BackBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Photo
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Entity
 *
 * @ExclusionPolicy("none")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table()
 * @ORM\Entity(repositoryClass = "Barra\BackBundle\Entity\Repository\PhotoRepository")
 */
class Photo
{
    use IdAutoTrait,
        NameTrait,
        ImageTrait
    ;

    /**
     * @var Recipe
     * @Assert\NotNull()
     * @ORM\ManyToOne(
     *      targetEntity = "Recipe",
     *      inversedBy   = "photos"
     * )
     * @ORM\JoinColumn(
     *      name                 = "recipe",
     *      referencedColumnName = "id",
     *      nullable             = false,
     *      onDelete             = "CASCADE"
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $recipe;

    /**
     * Set recipe
     * @param Recipe $recipe
     * @return $this
     */
    public function setRecipe(Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }
}
