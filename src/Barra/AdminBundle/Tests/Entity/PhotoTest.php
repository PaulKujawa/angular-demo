<?php

namespace Barra\AdminBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Photo;

/**
 * Class PhotoTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Tests\Entity
 */
class PhotoTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN              = 'Barra\AdminBundle\Entity\Photo';
    const RECIPE_FQDN            = 'Barra\AdminBundle\Entity\Recipe';
    const UPLOADED_DOCUMENT_FQDN = 'Symfony\Component\HttpFoundation\File\UploadedFile';
    const ID                     = 2;
    const SIZE                   = 33;
    const NAME                   = 'demoName';
    const FILENAME               = 'demoFilename';
    const WEB_DIRECTORY          = 'uploads/documents';


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
     * @return Photo
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
     * @param Photo $self
     */
    public function testGetName(Photo $self)
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
     * @return Photo
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
     * @param Photo $self
     */
    public function testGetFilename(Photo $self)
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
     * @param Photo $self
     * @depends testSetFilename
     */
    public function testGetWebDirectoryWithFilename(Photo $self)
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
     * @param Photo $self
     * @depends testSetFilename
     */
    public function testSetFileWithPreviousSetFilename(Photo $self)
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
     * @return Photo
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
     * @param Photo $self
     */
    public function testGetSizeTest(Photo $self)
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
     * @return Photo
     */
    public function testSetRecipe()
    {
        $mock     = $this->getMock(self::RECIPE_FQDN);
        $resource = $this->model->setRecipe($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testSetRecipe
     * @param Photo $self
     */
    public function testGetRecipe(Photo $self)
    {
        $mock   = $this->getMock(self::RECIPE_FQDN);
        $recipe = $self->getRecipe();

        $this->assertEquals(
            $mock,
            $recipe
        );
    }


    /**
     * @return Photo
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
     * @param Photo $self
     */
    public function testGetFile(Photo $self)
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


    public function testIsRemovableTrue()
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
}
