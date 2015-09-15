<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\FrontBundle\Entity\Manufacturer;
use Barra\FrontBundle\Entity\Product;

/**
 * Class ManufacturerTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class ManufacturerTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN         = 'Barra\FrontBundle\Entity\Manufacturer';
    const PRODUCT_FQDN      = 'Barra\FrontBundle\Entity\Product';
    const ID                = 2;
    const NAME              = 'demoName';

    /** @var  Manufacturer $model */
    protected $model;

    /**
     * Initialises model entity
     */
    public function setUp()
    {
        $this->model = new Manufacturer();
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
     * @return Manufacturer
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
     * @param Manufacturer $self
     */
    public function getNameTest(Manufacturer $self)
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
     * @return Manufacturer
     */
    public function addProduct()
    {
        $productMock = $this->getMock(self::PRODUCT_FQDN);
        $resource      = $this->model->addProduct($productMock);
        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }

    /**
     * @test
     * @depends addProduct
     * @param Manufacturer $self
     * @return Product
     */
    public function getProducts(Manufacturer $self)
    {
        $products  = $self->getProducts();
        $product   = $products->get(0);

        $this->assertCount(
            1,
            $products
        );

        $productMock = $this->getMock(self::PRODUCT_FQDN);
        $this->assertEquals(
            $productMock,
            $product
        );

        return $product;
    }

    /**
     * @test
     * @depends addProduct
     * @depends getProducts
     * @param Manufacturer  $self
     * @param Product       $product
     */
    public function removeProduct(Manufacturer $self, Product $product)
    {
        $resource = $self->removeProduct($product);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        $this->assertCount(
            0,
            $self->getProducts()
        );
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function addInvalidProduct()
    {
        $this->model->addProduct(1);
    }

    /**
     * @test
     * @expectedException PHPUnit_Framework_Error
     */
    public function removeInvalidProduct()
    {
        $this->model->removeProduct(1);
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
        ];
    }
}
