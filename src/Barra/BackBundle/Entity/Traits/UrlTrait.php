<?php

namespace Barra\BackBundle\Entity\Traits;

/**
 * Class UrlTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Entity\Traits
 */
trait UrlTrait
{
    /**
     * @var string
     * @ORM\Column(
     *      name        = "url",
     *      type        = "string",
     *      length      = 50,
     *      nullable    = false,
     *      unique      = true
     * )
     */
    private $url;

    /**
     * Set url
     *
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
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
