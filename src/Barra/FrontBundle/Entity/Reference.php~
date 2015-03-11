<?php

namespace Barra\FrontBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;

/**
 * Reference
 * @ExclusionPolicy("none")
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Barra\FrontBundle\Entity\Repository\ReferenceRepository")
 * @ORM\HasLifecycleCallbacks
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
     * @ORM\Column(name="url", type="string", length=50, unique=true)
     */
    private $url;

    /**
     * @ORM\Column(name="description", type="string", length=50)
     */
    private $description;

    /**
     * @Exclude
     * @ORM\Column(name="started", type="date")
     */
    private $started;

    /**
     * @Exclude
     * @ORM\Column(name="finished", type="date")
     */
    private $finished;

    /**
     * @ORM\ManyToOne(targetEntity="Agency", inversedBy="references")
     * @ORM\JoinColumn(name="agency", referencedColumnName="id", nullable=false)
     */
    private $agency;

    /**
     * @ORM\ManyToMany(targetEntity="Technique", inversedBy="references")
     * @ORM\JoinTable(name="ReferenceTechnique")
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $techniques;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(name="filename", type="string", length=255, unique=true, nullable=true)
     */
    private $filename;

    /**
     * @ORM\Column(name="size", type="integer", nullable=true)
     */
    private $size;

    /**
     * @ORM\OneToMany(targetEntity="ReferencePicture", mappedBy="recipe")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $referencePictures;

    /**
     * @Assert\File(maxSize="2M", mimeTypes = {"image/*"})
     */
    private $file;

    /**
     * temp var for encoded filename
     */
    private $temp;




    /**
     * Constructor
     */
    public function __construct()
    {
        $this->techniques = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    /**
     * Set agency
     *
     * @param \Barra\FrontBundle\Entity\Agency $agency
     * @return Reference
     */
    public function setAgency(\Barra\FrontBundle\Entity\Agency $agency)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return \Barra\FrontBundle\Entity\Agency 
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Add techniques
     *
     * @param \Barra\FrontBundle\Entity\Technique $techniques
     * @return Reference
     */
    public function addTechnique(\Barra\FrontBundle\Entity\Technique $techniques)
    {
        $this->techniques[] = $techniques;

        return $this;
    }

    /**
     * Remove techniques
     *
     * @param \Barra\FrontBundle\Entity\Technique $techniques
     */
    public function removeTechnique(\Barra\FrontBundle\Entity\Technique $techniques)
    {
        $this->techniques->removeElement($techniques);
    }

    /**
     * Get techniques
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTechniques()
    {
        return $this->techniques;
    }

    /**
     * Add referencePictures
     *
     * @param \Barra\FrontBundle\Entity\ReferencePicture $referencePictures
     * @return Reference
     */
    public function addReferencePicture(\Barra\FrontBundle\Entity\ReferencePicture $referencePictures)
    {
        $this->referencePictures[] = $referencePictures;

        return $this;
    }

    /**
     * Remove referencePictures
     *
     * @param \Barra\FrontBundle\Entity\ReferencePicture $referencePictures
     */
    public function removeReferencePicture(\Barra\FrontBundle\Entity\ReferencePicture $referencePictures)
    {
        $this->referencePictures->removeElement($referencePictures);
    }

    /**
     * Get referencePictures
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReferencePictures()
    {
        return $this->referencePictures;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Reference
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set size
     *
     * @param integer $size
     * @return Reference
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param ReferencePicture $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
        if (isset($this->filename)) {
            $this->temp = $this->filename;
            $this->filename = null;
        } else
            $this->filename = $this->file->getClientOriginalName();
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }





    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/documents';
    }

    public function getAbsolutePath()
    {
        return $this->filename === null
            ? null
            : $this->getUploadRootDir().'/'.$this->filename;
    }

    public function getWebPath()
    {
        return $this->filename === null
            ? null
            : $this->getUploadDir().'/'.$this->filename;
    }








    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if ($this->getFile() !== null) {
            $filename = sha1(uniqid(mt_rand(), true));
            $extension = $this->getFile()->guessExtension();
            $this->title = $this->filename;
            $this->filename = $filename.'.'.$extension;
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if ($this->getFile() === null)
            return;

        $this->getFile()->move($this->getUploadRootDir(), $this->filename);

        if (isset($this->temp)) {
            unlink($this->getUploadRootDir().'/'.$this->temp);
            $this->temp = null;
        }

        $this->file = null;
    }

    /**
     * Called before entity removal
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath())
            unlink($file);
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Reference
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
}
