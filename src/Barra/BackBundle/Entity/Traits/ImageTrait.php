<?php

namespace Barra\BackBundle\Entity\Traits;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ImageTrait
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\BackBundle\Entity\Traits
 */
trait ImageTrait
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

    // todo check correct image sizes
    /**
     * @var UploadedFile
     * @Assert\NotNull()
     * @Assert\Image(
     *      mimeTypes   = "image/*",
     *      maxSize     = "2M",
     *      minWidth    = 200,
     *      maxWidth    = 400,
     *      minHeight   = 200,
     *      maxHeight   = 400
     * )
     */
    private $file;

    /**
     * @var string
     * temp var for encoded filename
     */
    private $oldImageFilename;




    // ### LIFECYCLE FUNCTIONS
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     * @return $this
     */
    public function generateFilename()
    {
        if (null === $this->getFile()) {
            return $this;
        }
        $this->filename = sha1(uniqid(mt_rand(), true)).'.'.$this->getFile()->guessExtension();

        return $this;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     * @return $this
     * @throws FileException if, for any reason, the file could not have been moved
     */
    public function saveFile()
    {
        if (null === $this->getFile()) {
            return $this;
        }
        $this->getFile()->move($this->getAbsolutePath(), $this->filename);

        if (isset($this->oldImageFilename)) {
            unlink($this->getAbsolutePath().'/'.$this->oldImageFilename);
        }

        return $this;
    }

    /**
     * @ORM\PostRemove()
     * @return $this
     */
    public function removeFile()
    {
        $file = $this->getAbsolutePathWithFilename();
        if (null !== $file) {
            unlink($file);
            // just relevant if manually called to set a new file afterwards
            $this->oldImageFilename = $this->filename;
            $this->size             = null;
            $this->file             = null;
            $this->filename         = null;
        }

        return $this;
    }






    // ### FILE PATH
    /**
     * @return null|string
     */
    public function getAbsolutePathWithFilename()
    {
        return null === $this->filename
            ? null
            : $this->getAbsolutePath().DIRECTORY_SEPARATOR.$this->filename
        ;
    }

    /**
     * @return string
     */
    public function getAbsolutePath()
    {
        return __DIR__.'/../../../../../web/'.$this->getWebDirectory();
    }

    /**
     * @return null|string
     */
    public function getWebDirectoryWithFilename()
    {
        return null === $this->filename
            ? null
            : $this->getWebDirectory().DIRECTORY_SEPARATOR.$this->filename
        ;
    }

    /**
     * @return string
     */
    public function getWebDirectory()
    {
        return 'uploads'.DIRECTORY_SEPARATOR.'documents';
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

        if (null !== $this->filename) {
            $this->oldImageFilename = $this->filename;
            $this->filename         = null;
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
