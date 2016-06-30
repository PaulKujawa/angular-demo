<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\DescriptionTrait;
use AppBundle\Entity\Traits\IdAutoTrait;
use AppBundle\Entity\Traits\PositionTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ExclusionPolicy("none")
 *
 * @UniqueEntity({
 *      "recipe",
 *      "position"
 * })
 *
 * @ORM\Table()
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass = "AppBundle\Entity\Repository\RecipeRelatedRepository")
 */
class Cooking
{
    use DescriptionTrait;
    use IdAutoTrait;
    use PositionTrait;

    /**
     * @var Recipe
     *
     * @Assert\NotNull()
     *
     * @Exclude
     *
     * @ORM\ManyToOne(
     *      targetEntity = "Recipe",
     *      inversedBy   = "cookings"
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
     * @param Recipe $recipe
     *
     * @return $this
     */
    public function setRecipe(Recipe $recipe)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * @return Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * @return bool
     */
    public function isRemovable()
    {
        return true;
    }
}
