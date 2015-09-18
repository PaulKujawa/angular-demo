<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\FrontBundle\Entity\Photo;

/**
 * Class PhotoTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class PhotoTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN              = 'Barra\FrontBundle\Entity\Photo';
    const RECIPE_FQDN            = 'Barra\FrontBundle\Entity\Recipe';
    const UPLOADED_DOCUMENT_FQDN = 'Symfony\Component\HttpFoundation\File\UploadedFile';
    const ID                     = 2;
    const SIZE                   = 33;
    const NAME                   = 'demoName';
    const FILENAME               = 'demoFilename';
    const WEB_DIRECTORY          = 'uploads/documents';

    /** @var  Photo $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new Photo();
    }

    /**
     * Sets protected id field first to test the get function
     * @test
     */
    public function getId()
    {
        $reflected = new \ReflectionClass(self::SELF_FQDN);
        $idField   = $reflected->getProperty('id');
        $idField->setAccessible(true);
        $idField->setValue($this->model, self::ID);

        $got = $this->model->getId();
        $this->assertInternalType(
            'int',
            $got
        );

        $this->assertEquals(
            self::ID,
            $got
        );
    }

    /**
     * @test
     * @return Photo
     */
    public function setNameTest()
    {
        $resource = $this->model->setName(self::NAME);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setNameTest
     * @param Photo $self
     */
    public function getNameTest(Photo $self)
    {
        $got = $self->getName();
        $this->assertInternalType(
            'string',
            $got
        );

        $this->assertEquals(
            self::NAME,
            $got
        );
    }

    /**
     * @test
     * @return Photo
     */
    public function setFilename()
    {
        $resource = $this->model->setFilename(self::FILENAME);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setFilename
     * @param Photo $self
     */
    public function getFilename(Photo $self)
    {
        $got = $self->getFilename();
        $this->assertInternalType(
            'string',
            $got
        );

        $this->assertEquals(
            self::FILENAME,
            $got
        );
    }

    /**
     * @test
     * @param Photo $self
     * @depends setFilename
     */
    public function getWebDirectoryWithFilename(Photo $self)
    {
        $this->assertNull(
            $this->model->getWebDirectoryWithFilename()
        );

        // todo assert path
        $got = $self->getWebDirectoryWithFilename();
        $this->assertInternalType(
            'string',
            $got
        );

        $directory = substr($got, 0, strrpos($got, '/'));
        $this->assertEquals(
            self::WEB_DIRECTORY,
            $directory
        );
    }

    /**
     * @test
     * @param Photo $self
     * @depends setFilename
     */
    public function setFileWithPreviousSetFilename(Photo $self)
    {
        $fileMock = $this->getMock(self::UPLOADED_DOCUMENT_FQDN, [], [], '', false);
        $fileMock
            ->expects($this->never())
            ->method('getClientOriginalName')
            ->will($this->returnValue('someName'))
        ;

        $resource = $self->setFile($fileMock);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );
    }

    /**
     * @test
     * @return Photo
     */
    public function setSize()
    {
        $resource = $this->model->setSize(self::SIZE);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setSize
     * @param Photo $self
     */
    public function getSizeTest(Photo $self)
    {
        $got = $self->getSize();
        $this->assertInternalType(
            'int',
            $got
        );

        $this->assertEquals(
            self::SIZE,
            $got
        );
    }

    /**
     * @test
     * @return Photo
     */
    public function setRecipe()
    {
        $recipeMock = $this->getMock(self::RECIPE_FQDN);
        $resource   = $this->model->setRecipe($recipeMock);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setRecipe
     * @param Photo $self
     */
    public function getRecipe(Photo $self)
    {
        $recipe     = $self->getRecipe();
        $recipeMock = $this->getMock(self::RECIPE_FQDN);
        $this->assertEquals(
            $recipeMock,
            $recipe
        );
    }

    /**
     * @test
     * @return Photo
     */
    public function setFile()
    {
        $fileMock = $this->getMock(self::UPLOADED_DOCUMENT_FQDN, [], [], '', false);
        $fileMock
            ->expects($this->once())
            ->method('getClientOriginalName')
            ->will($this->returnValue('someName'))
        ;

        $resource = $this->model->setFile($fileMock);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setFile
     * @param Photo $self
     */
    public function getFile(Photo $self)
    {
        $file     = $self->getFile();
        $fileMock = $this->getMock(self::UPLOADED_DOCUMENT_FQDN, [], [], '', false);
        $this->assertEquals(
            $fileMock,
            $file
        );
    }

    /**
     * @test
     */
    public function generateFilename()
    {
        $fileMock = $this->getMock(self::UPLOADED_DOCUMENT_FQDN, [], [], '', false);
        $fileMock
            ->expects($this->once())
            ->method('getClientOriginalName')
            ->will($this->returnValue('someName'))
        ;

        $fileMock
            ->expects($this->once())
            ->method('guessExtension')
            ->will($this->returnValue('jpg'))
        ;

        $this->model
            ->setFile($fileMock)
            ->generateFilename()
        ;

        $this->assertInternalType(
            'string',
            $this->model->getFilename()
        );
    }

    /**
     * @test
     */
    public function generateFileNameNegative()
    {
        $resource = $this->model->generateFilename();
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );
    }

    /**
     * @test
     */
    public function getWebDirectory()
    {
        $got = $this->model->getWebDirectory();
        $this->assertInternalType(
            'string',
            $got
        );

        $this->assertEquals(
            self::WEB_DIRECTORY,
            $got
        );
    }

    /**
     * @test
     * @param string    $field
     * @param mixed     $value
     * @expectedException PHPUnit_Framework_Error
     * @dataProvider providerSetInvalidComplexValues
     */
    public function setInvalidComplexValues($field, $value)
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
            ]
        ];
    }

    /**
     * @test
     * @param string    $field
     * @param mixed     $value
     * @expectedException \InvalidArgumentException
     * @dataProvider providerSetInvalidNativeValues
     */
    public function setInvalidNativeValues($field, $value)
    {
        $this->model->{'set'.ucfirst($field)}($value);
    }

    /**
     * Invalid native values for setter
     * @return array
     */
    public static function providerSetInvalidNativeValues()
    {
        return [
            [
                'name',
                1,
            ],
            [
                'size',
                '1',
            ],
            [
                'filename',
                1,
            ]
        ];
    }
}
