<?php

namespace Barra\FrontBundle\Entity\Traits;

/**
 * Class UrlTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity\Traits
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
     */
    public function setUrl($url)
    {
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
