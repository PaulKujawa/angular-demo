<?php

namespace Barra\FrontBundle\Entity\Traits;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class PictureTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Entity\Traits
 */
trait PictureTrait
{
    /**
     * @var string
     * @ORM\Column(
     *      name        = "filename",
     *      type        = "string",
     *      length      = 255,
     *      unique      = true,
     *      nullable    = true
     * )
     */
    private $filename;

    /**
     * @var int
     * @ORM\Column(
     *      name        = "size",
     *      type        = "integer",
     *      nullable    = true
     * )
     */
    private $size;

    /**
     * @var UploadedFile
     * @Assert\File(
     *      maxSize   = "2M",
     *      mimeTypes = {"image/*"},
     * )
     */
    private $file;

    /**
     * @var string
     * temp var for encoded filename
     */
    private $temp;




    // ### LIFECYCLE FUNCTIONS
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (!is_null($this->getFile())) {
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
        if (is_null($this->getFile())) {
            return;
        }

        $this->getFile()->move($this->getPath(), $this->filename);

        if (isset($this->temp)) {
            unlink($this->getPath().'/'.$this->temp);
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
        if ($file = $this->getPathWithFilename()) {
            unlink($file);
        }
    }






    // ### FILE PATH
    /**
     * @return null|string
     */
    public function getPathWithFilename()
    {
        return is_null($this->filename)
            ? null
            : $this->getPath().'/'.$this->filename;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return __DIR__.'/../../../../../web/'.$this->getDirectory();
    }

    /**
     * @return null|string  inclusive filename
     */
    public function getWebPathWithFilename()
    {
        return is_null($this->filename)
            ? null
            : $this->getDirectory().'/'.$this->filename;
    }


    /**
     * @return string   sub directory
     */
    public function getDirectory()
    {
        return 'uploads/documents';
    }




    // ### GETTER AND SETTER ###
    /**
     * Set filename
     *
     * @param string $filename
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setFilename($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'filename',
                'string'
            ));
        }
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
     * @param int $size
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setSize($size)
    {
        if (!is_int($size)) {
            throw new \InvalidArgumentException(sprintf(
                '"%s" needs to be of type "%s',
                'size',
                'int'
            ));
        }
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

    /**
     * @param UploadedFile $file
     * @return $this
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        if (isset($this->filename)) {
            $this->temp = $this->filename;
            $this->filename = null;
        } else {
            $this->filename = $this->file->getClientOriginalName();
        }

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }
}
