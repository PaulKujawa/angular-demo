<?php

namespace Barra\FrontBundle\Entity\Traits;

/**
 * Class NameTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity\Traits
 */
trait NameTrait
{
    /**
     * @ORM\Column(
     *      name   = "name",
     *      type   = "string",
     *      length = 40,
     *      unique = true
     * )
     */
    private $name;

    /**
     * @param string $name
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setName($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'name',
                'string'
            ));
        }
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
