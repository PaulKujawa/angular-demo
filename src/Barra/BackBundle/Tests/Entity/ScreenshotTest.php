<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\BackBundle\Entity\Screenshot;

/**
 * Class ScreenshotTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class ScreenshotTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN              = 'Barra\BackBundle\Entity\Screenshot';
    const REFERENCE_FQDN         = 'Barra\BackBundle\Entity\Reference';
    const ID                     = 2;
    const SIZE                   = 33;
    const NAME                   = 'demoName';
    const UPLOADED_DOCUMENT_FQDN = 'Symfony\Component\HttpFoundation\File\UploadedFile';
    const FILENAME               = 'demoFilename';
    const WEB_DIRECTORY          = 'uploads/documents';

    /** @var  Screenshot $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new Screenshot();
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
     * @return Screenshot
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
     * @param Screenshot $self
     */
    public function getNameTest(Screenshot $self)
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
     * @return Screenshot
     */
    public function setReference()
    {
        $mock     = $this->getMock(self::REFERENCE_FQDN);
        $resource = $this->model->setReference($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setReference
     * @param Screenshot $self
     */
    public function getReference(Screenshot $self)
    {
        $mock      = $this->getMock(self::REFERENCE_FQDN);
        $reference = $self->getReference();

        $this->assertEquals(
            $mock,
            $reference
        );
    }

    /**
     * @test
     * @return Screenshot
     */
    public function setFile()
    {
        $mock = $this->getMock(self::UPLOADED_DOCUMENT_FQDN, [], [], '', false);
        $mock
            ->expects($this->once())
            ->method('getClientOriginalName')
            ->will($this->returnValue('someName'))
        ;
        $resource = $this->model->setFile($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends setFile
     * @param Screenshot $self
     */
    public function getFile(Screenshot $self)
    {
        $mock = $this->getMock(self::UPLOADED_DOCUMENT_FQDN, [], [], '', false);
        $file = $self->getFile();

        $this->assertEquals(
            $mock,
            $file
        );
    }

    /**
     * @test
     */
    public function generateFilename()
    {
        $mock = $this->getMock(self::UPLOADED_DOCUMENT_FQDN, [], [], '', false);
        $mock
            ->expects($this->once())
            ->method('getClientOriginalName')
            ->will($this->returnValue('someName'))
        ;

        $mock
            ->expects($this->once())
            ->method('guessExtension')
            ->will($this->returnValue('jpg'))
        ;

        $this->model
            ->setFile($mock)
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
     * @return Screenshot
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
     * @param Screenshot $self
     */
    public function getFilename(Screenshot $self)
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
     * @param Screenshot $self
     * @depends setFilename
     */
    public function getWebDirectoryWithFilename(Screenshot $self)
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
     * @param Screenshot $self
     * @depends setFilename
     */
    public function setFileWithPreviousSetFilename(Screenshot $self)
    {
        $mock = $this->getMock(self::UPLOADED_DOCUMENT_FQDN, [], [], '', false);
        $mock
            ->expects($this->never())
            ->method('getClientOriginalName')
            ->will($this->returnValue('someName'))
        ;
        $resource = $self->setFile($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );
    }

    /**
     * @test
     * @return Screenshot
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
     * @param Screenshot $self
     */
    public function getSizeTest(Screenshot $self)
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
                'reference',
                1,
            ],
            [
                'file',
                1,
            ],
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
            ],
        ];
    }
}
