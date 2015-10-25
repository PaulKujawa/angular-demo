<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Screenshot;

/**
 * Class ScreenshotTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class ScreenshotTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN              = 'Barra\AdminBundle\Entity\Screenshot';
    const REFERENCE_FQDN         = 'Barra\AdminBundle\Entity\Reference';
    const ID                     = 2;
    const SIZE                   = 33;
    const NAME                   = 'demoName';
    const UPLOADED_DOCUMENT_FQDN = 'Symfony\Component\HttpFoundation\File\UploadedFile';
    const FILENAME               = 'demoFilename';
    const WEB_DIRECTORY          = 'uploads/documents';


    /** @var  Screenshot */
    protected $model;


    public function setUp()
    {
        $this->model = new Screenshot();
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
     * @return Screenshot
     */
    public function testSetName()
    {
        $resource = $this->model->setName(self::NAME);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetName
     * @param Screenshot $self
     */
    public function testGetName(Screenshot $self)
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
     * @return Screenshot
     */
    public function testSetReference()
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
     * @depends testSetReference
     * @param Screenshot $self
     */
    public function testGetReference(Screenshot $self)
    {
        $mock      = $this->getMock(self::REFERENCE_FQDN);
        $reference = $self->getReference();

        $this->assertEquals(
            $mock,
            $reference
        );
    }


    /**
     * @return Screenshot
     */
    public function testSetFile()
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
     * @depends testSetFile
     * @param Screenshot $self
     */
    public function testGetFile(Screenshot $self)
    {
        $mock = $this->getMock(self::UPLOADED_DOCUMENT_FQDN, [], [], '', false);
        $file = $self->getFile();

        $this->assertEquals(
            $mock,
            $file
        );
    }


    public function testGenerateFilename()
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


    public function testGenerateFileNameNegative()
    {
        $resource = $this->model->generateFilename();
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );
    }


    public function testGetWebDirectory()
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
     * @return Screenshot
     */
    public function testSetFilename()
    {
        $resource = $this->model->setFilename(self::FILENAME);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetFilename
     * @param Screenshot $self
     */
    public function testGetFilename(Screenshot $self)
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
     * @param Screenshot $self
     * @depends testSetFilename
     */
    public function testGetWebDirectoryWithFilename(Screenshot $self)
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
     * @param Screenshot $self
     * @depends testSetFilename
     */
    public function testSetFileWithPreviousSetFilename(Screenshot $self)
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
     * @return Screenshot
     */
    public function testSetSize()
    {
        $resource = $this->model->setSize(self::SIZE);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetSize
     * @param Screenshot $self
     */
    public function testGetSizeTest(Screenshot $self)
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


    public function testisRemovableTrue()
    {
        $got = $this->model->isRemovable();
        $this->assertInternalType(
            'bool',
            $got
        );

        $this->assertEquals(
            true,
            $got
        );
    }


    /**
     * @param string    $field
     * @param mixed     $value
     * @expectedException PHPUnit_Framework_Error
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
     * @param string    $field
     * @param mixed     $value
     * @expectedException \InvalidArgumentException
     * @dataProvider providerSetInvalidNativeValues
     */
    public function testSetInvalidNativeValues($field, $value)
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
