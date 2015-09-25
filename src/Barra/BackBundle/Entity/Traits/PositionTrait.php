<?php

namespace Barra\BackBundle\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PositionTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Entity
 */
trait PositionTrait
{
    /**
     * @var int
     * @Assert\NotNull()
     * @Assert\GreaterThanOrEqual(
     *      value = 1
     * )
     * @ORM\Column(
     *      name = "position",
     *      type = "smallint"
     * )
     */
    private $position;

    /**
     * Set position
     *
     * @param int $position
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setPosition($position)
    {
        if (!is_int($position)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'position',
                'int'
            ));
        }
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }
}
