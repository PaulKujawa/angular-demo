<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reference
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Reference
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="url", type="string", length=30, unique=true)
     */
    private $url;

    /**
     * @ORM\Column(name="agency", type="string", length=30)
     */
    private $agency;

    /**
     * @ORM\Column(name="agencyUrl", type="string", length=30)
     */
    private $agencyUrl;


    /**
     * @ORM\Column(name="description", type="string", length=30)
     */
    private $description;

    /**
     * @ORM\Column(name="started", type="date")
     */
    private $started;

    /**
     * @ORM\Column(name="finished", type="date")
     */
    private $finished;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Reference
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

    /**
     * Set agency
     *
     * @param string $agency
     * @return Reference
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return string 
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Set agencyUrl
     *
     * @param string $agencyUrl
     * @return Reference
     */
    public function setAgencyUrl($agencyUrl)
    {
        $this->agencyUrl = $agencyUrl;

        return $this;
    }

    /**
     * Get agencyUrl
     *
     * @return string 
     */
    public function getAgencyUrl()
    {
        return $this->agencyUrl;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Reference
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set started
     *
     * @param \DateTime $started
     * @return Reference
     */
    public function setStarted($started)
    {
        $this->started = $started;

        return $this;
    }

    /**
     * Get started
     *
     * @return \DateTime 
     */
    public function getStarted()
    {
        return $this->started;
    }

    /**
     * Set finished
     *
     * @param \DateTime $finished
     * @return Reference
     */
    public function setFinished($finished)
    {
        $this->finished = $finished;

        return $this;
    }

    /**
     * Get finished
     *
     * @return \DateTime 
     */
    public function getFinished()
    {
        return $this->finished;
    }
}
