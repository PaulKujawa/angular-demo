<?php

namespace Barra\RecipeBundle\Tests\Entity;

use Barra\RecipeBundle\Entity\Photo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class PhotoTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RecipeBundle\Tests\Entity
 */
class PhotoTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN          = 'Barra\RecipeBundle\Entity\Photo';
    const RECIPE_FQDN        = 'Barra\RecipeBundle\Entity\Recipe';
    const WEB_DIRECTORY      = 'images/uploads';
    const ID                 = 2;

    /** @var  Photo */
    protected $model;

    public function setUp()
    {
        $this->model = new Photo();
    }

    /**
     * Sets protected id field first to test the get function
     */
    public function testGetId()
    {
        $reflected = new \ReflectionClass(self::SELF_FQDN);
        $idField   = $reflected->getProperty('id');
        $idField->setAccessible(true);
        $idField->setValue($this->model, self::ID);

        $got = $this->model->getId();
        $this->assertEquals(self::ID, $got);
    }

    /**
     * @return Photo
     */
    public function testSetRecipe()
    {
        $mock     = $this->getMock(self::RECIPE_FQDN);
        $resource = $this->model->setRecipe($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetRecipe
     * @param Photo $self
     */
    public function testGetRecipe(Photo $self)
    {
        $mock = $this->getMock(self::RECIPE_FQDN);
        $this->assertEquals($mock, $self->getRecipe());
    }

    public function testGetWebDirectory()
    {
        $got = $this->model->getWebDirectory();
        $this->assertEquals(self::WEB_DIRECTORY, $got);
    }

    public function testGetAbsolutePath()
    {
        $got = $this->model->getAbsolutePath();
        $this->assertStringEndsWith(self::WEB_DIRECTORY, $got);
    }

    public function testIsRemovable()
    {
        $this->assertTrue($this->model->isRemovable());
    }

    /**
     * @return Photo
     */
    public function testSetFile()
    {
        $photo    = $this->createPhotoFile();
        $resource = $this->model->setFile($photo);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    // ----------------------------------------------------------------------------------------

    /**
     * @depends testSetFile
     * @param Photo $self
     */
    public function testGetFile(Photo $self)
    {
        $this->assertNotNull($self->getFile());
    }

    /**
     * @depends testSetFile
     * @param Photo $self
     */
    public function testGetSize(Photo $self)
    {
        $this->assertEquals($self->getFile()->getSize(), $self->getSize());
    }

    /**
     * @depends testSetFile
     * @param Photo $self
     * @return Photo
     */
    public function testGenerateFilename(Photo $self)
    {
        $resource = $self->generateFilename();
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    // ----------------------------------------------------------------------------------------

    /**
     * @depends testGenerateFilename
     * @param Photo $self
     * @return Photo
     */
    public function testGetFilename(Photo $self)
    {
        $this->assertStringEndsWith('.jpeg', $self->getFilename());

        return $self;
    }

    /**
     * @depends testGenerateFilename
     * @depends testGetWebDirectory
     * @param Photo $self
     */
    public function testGetWebDirectoryWithFilename(Photo $self)
    {
        $this->assertNull($this->model->getWebDirectoryWithFilename());
        $this->assertEquals(
            $self->getWebDirectoryWithFilename(),
            self::WEB_DIRECTORY.'/'.$self->getFilename()
        );
    }

    /**
     * @depends testGenerateFilename
     * @depends testGetAbsolutePath
     * @param Photo $self
     */
    public function testGetAbsolutePathWithFilename(Photo $self)
    {
        $this->assertNull($this->model->getAbsolutePathWithFilename());
        $this->assertEquals(
            $self->getAbsolutePathWithFilename(),
            $self->getAbsolutePath().'/'.$self->getFilename()
        );
    }

    /**
     * @depends testGenerateFilename
     * @param Photo $self
     * @return Photo
     */
    public function testSaveFile(Photo $self)
    {
        $resource = $self->saveFile();
        $this->assertInstanceOf(self::SELF_FQDN, $resource);
        $this->assertFileExists($self->getAbsolutePathWithFilename());

        return $resource;
    }

    // ----------------------------------------------------------------------------------------

    /**
     * @depends testSaveFile
     * @param Photo $self
     */
    public function testRemoveFile(Photo $self)
    {
        $path = $self->getAbsolutePathWithFilename();
        $this->assertInstanceOf(self::SELF_FQDN, $self->removeFile());
        $this->assertFileNotExists($path);
    }

    /**
     * @depends testRemoveFile
     * @return Photo
     */
    public function testFileOverwrite()
    {
        $photo = $this->createPhotoFile();
        $this->model
            ->setFile($photo)
            ->generateFilename()
            ->saveFile();
        $path = $this->model->getAbsolutePathWithFilename();
        $this->assertFileExists($path);

        // overwrite (and implicitly remove) old file with a new one
        $photo = $this->createPhotoFile();
        $this->model->setFile($photo);
        $this->assertFileNotExists($path);

        unlink($photo->getPath().'/'.$photo->getFilename());
    }

    // ----------------------------------------------------------------------------------------

    /**
     * @param string    $field
     * @param mixed     $value
     * @expectedException \PHPUnit_Framework_Error
     * @dataProvider providerSetInvalidComplexValues
     */
    public function testSetInvalidComplexValues($field, $value)
    {
        $this->model->{'set'.ucfirst($field)}($value);
    }

    /**
     * Invalid complex values for setter
     * @return array
     */
    public static function providerSetInvalidComplexValues()
    {
        return [
            [
                'recipe',
                1,
            ],
            [
                'file',
                1,
            ],
        ];
    }


    /**
     * @return UploadedFile
     */
    protected function createPhotoFile()
    {
        $path     = $this->model->getAbsolutePath().'/';
        $filename = 'unitTest.jpg';
        $newFile  = $path.$filename;

        copy($path.'fixture.jpg', $newFile);

        $photo = new UploadedFile(
            $newFile,
            $filename,
            'image/jpeg',
            filesize($newFile),
            null,
            true
        );

        return $photo;
    }
}
