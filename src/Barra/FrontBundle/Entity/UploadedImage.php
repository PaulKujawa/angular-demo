<?php

namespace Barra\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * UploadedImage
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks
 */
class UploadedImage
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @ORM\Column(name="filename", type="string", length=255, unique=true)
     */
    private $filename;

    /**
     * @Assert\File(maxSize="4M", mimeTypes = {"image/*"})
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="uploadedImages")
     * @ORM\JoinColumn(name="recipe", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    protected $recipe;

    /**
     * temp var for encoded filename
     */
    private $temp;

    /**
     * @ORM\Column(name="size", type="integer")
     */
    private $size;






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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return UploadedImage
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

    /**
     * Set filename
     *
     * @param string $filename
     * @return UploadedImage
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
     * @param UploadedImage $file
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

    /**
     * Set recipe
     *
     * @param \Barra\FrontBundle\Entity\Recipe $recipe
     * @return UploadedImage
     */
    public function setRecipe(\Barra\FrontBundle\Entity\Recipe $recipe = null)
    {
        $this->recipe = $recipe;
        return $this;
    }

    /**
     * Get recipe
     *
     * @return \Barra\FrontBundle\Entity\Recipe 
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set size
     *
     * @param string $size
     * @return UploadedDocument
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }
}
