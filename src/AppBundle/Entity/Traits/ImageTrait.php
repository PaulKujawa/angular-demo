<?php

namespace AppBundle\Entity\Traits;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

trait ImageTrait
{
    /**
     * @var string
     *
     * @Serializer\Exclude()
     *
     * @ORM\Column(
     *      name = "filename",
     *      type = "string",
     *      length = 255,
     *      nullable = true,
     *      unique = true
     * )
     */
    private $filename;

    /**
     * @var int
     *
     * @Assert\GreaterThan(value = 0)
     *
     * @ORM\Column(
     *      name  = "size",
     *      type = "integer",
     *      nullable = true
     * )
     */
    private $size;

    /**
     * @var UploadedFile
     *
     * @Serializer\Exclude()
     *
     * @Assert\Image(
     *      mimeTypes = "image/*",
     *      maxSize = "100K",
     *      minWidth = 400,
     *      maxWidth = 400,
     *      minHeight = 300,
     *      maxHeight = 600
     * )
     */
    private $file;

    // ### FILE PATH -----------------------------------------------------------------------------
    /**
     * @return null|string
     */
    public function getAbsolutePathWithFilename()
    {
        return null === $this->filename
            ? null
            : $this->getAbsolutePath() . '/' . $this->filename;
    }

    /**
     * @return string
     */
    public function getAbsolutePath()
    {
        return __DIR__ . '/../../../../../web/' . $this->getWebDirectory();
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("path")
     *
     * @return null|string
     */
    public function getWebDirectoryWithFilename()
    {
        return null === $this->filename
            ? null
            : $this->getWebDirectory() . '/' . $this->filename;
    }

    /**
     * @return string
     */
    public function getWebDirectory()
    {
        return 'images/uploads';
    }

    // ### LIFECYCLE FUNCTIONS --------------------------------------------------------------------
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function generateFilename()
    {
        if (null === $this->file) {
            return;
        }

        do {
            $this->filename = sha1(uniqid(mt_rand(), true)) . '.' . $this->getFile()->guessExtension();
        } while (file_exists($this->getAbsolutePathWithFilename()));
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function saveFile()
    {
        if (null !== $this->getFile()) {
            $this->getFile()->move($this->getAbsolutePath(), $this->filename);
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeFile()
    {
        $path = $this->getAbsolutePathWithFilename();

        if(null === $path) {
            return;
        }

        $this->file = null;
        $this->size = null;
        $this->filename = null;
        unlink($path);
    }

    // ### GETTER AND SETTER --------------------------------------------------------------------
    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        if (null !== $this->filename) {
            $this->removeFile();
        }
        $this->file = $file;
        $this->size = $file->getClientSize();

        // @here you could save the original filename via $file->getClientOriginalName()
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }
}
