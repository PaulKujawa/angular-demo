<?php

namespace Barra\AdminBundle\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UrlTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Entity\Traits
 */
trait UrlTrait
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Url()
     *
     * @ORM\Column(
     *      name   = "url",
     *      type   = "string",
     *      length = 50,
     *      unique = true
     * )
     */
    private $url;

    /**
     * @param string $url
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setUrl($url)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'url',
                'string'
            ));
        }
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
