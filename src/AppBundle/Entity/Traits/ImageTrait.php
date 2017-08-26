<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
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
    public function getAbsolutePathWithFilename(): ?string
    {
        return null === $this->filename
            ? null
            : $this->getAbsolutePath() . '/' . $this->filename;
    }

    public function getAbsolutePath(): string
    {
        return __DIR__ . '/../../../../../web/' . $this->getWebDirectory();
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("path")
     */
    public function getWebDirectoryWithFilename(): ?string
    {
        return null === $this->filename
            ? null
            : $this->getWebDirectory() . '/' . $this->filename;
    }

    public function getWebDirectory(): string
    {
        return 'images/uploads';
    }

    // ### LIFECYCLE FUNCTIONS --------------------------------------------------------------------
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function generateFilename(): void
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
    public function saveFile(): void
    {
        if (null !== $this->getFile()) {
            $this->getFile()->move($this->getAbsolutePath(), $this->filename);
        }
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeFile(): void
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
    public function setFile(UploadedFile $file): void
    {
        if (null !== $this->filename) {
            $this->removeFile();
        }
        $this->file = $file;
        $this->size = $file->getClientSize();

        // @here you could save the original filename via $file->getClientOriginalName()
    }

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
