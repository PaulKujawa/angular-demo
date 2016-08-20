<?php

namespace AppBundle\Entity\Traits;

use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

trait ImageTrait
{
    /**
     * @var string
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

    // todo check correct image size
    /**
     * @var UploadedFile
     *
     * @Exclude()
     *
     * @Assert\Image(
     *      mimeTypes = "image/*",
     *      maxSize = "2M",
     *      minWidth = 200,
     *      maxWidth = 400,
     *      minHeight = 200,
     *      maxHeight = 400
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
     * @VirtualProperty
     * @SerializedName("path")
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
     *
     * @return $this
     */
    public function generateFilename()
    {
        if (null !== $this->file) {
            do {
                $this->filename = sha1(uniqid(mt_rand(), true)) . '.' . $this->getFile()->guessExtension();
            } while (file_exists($this->getAbsolutePathWithFilename()));
        }

        return $this;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     *
     * @return $this
     */
    public function saveFile()
    {
        if (null !== $this->getFile()) {
            $this->getFile()->move($this->getAbsolutePath(), $this->filename);
        }

        return $this;
    }

    /**
     * @ORM\PostRemove()
     *
     * @return $this
     */
    public function removeFile()
    {
        $path = $this->getAbsolutePathWithFilename();
        if (null !== $path) {
            $this->file = null;
            $this->size = null;
            $this->filename = null;
            unlink($path);
        }

        return $this;
    }

    // ### GETTER AND SETTER --------------------------------------------------------------------
    /**
     * @param UploadedFile $file
     *
     * @return $this
     */
    public function setFile(UploadedFile $file)
    {
        if (null !== $this->filename) {
            $this->removeFile();
        }
        $this->file = $file;
        $this->size = $file->getClientSize();

        // @here you could save the original filename via $file->getClientOriginalName()

        return $this;
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
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }
}
