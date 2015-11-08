<?php

namespace Barra\AdminBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Manufacturer;
use Barra\AdminBundle\Entity\Product;

/**
 * Class ManufacturerTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\AdminBundle\Tests\Entity
 */
class ManufacturerTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN         = 'Barra\AdminBundle\Entity\Manufacturer';
    const PRODUCT_FQDN      = 'Barra\AdminBundle\Entity\Product';
    const ID                = 2;
    const NAME              = 'demoName';


    /** @var  Manufacturer */
    protected $model;


    public function setUp()
    {
        $this->model = new Manufacturer();
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
     * @return Manufacturer
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
     * @param Manufacturer $self
     */
    public function testGetName(Manufacturer $self)
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
     * @return Manufacturer
     */
    public function testAddProduct()
    {
        $mock     = $this->getMock(self::PRODUCT_FQDN);
        $resource = $this->model->addProduct($mock);

        $this->assertInstanceOf(
            self::SELF_FQDN,
            $resource
        );

        return $resource;
    }


    /**
     * @depends testAddProduct
     * @param Manufacturer $self
     * @return Product
     */
    public function testGetProducts(Manufacturer $self)
    {
        $products  = $self->getProducts();
        $product   = $products[0];

        $this->assertCount(
            1,
            $products
        );

        $mock = $this->getMock(self::PRODUCT_FQDN);
        $this->assertEquals(
            $mock,
            $product
        );

        return $product;
    }


    /**
     * @depends testAddProduct
     * @depends testGetProducts
     * @param Manufacturer  $self
     * @param Product       $product
     */
    public function testRemoveProduct(Manufacturer $self, Product $product)
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


    public function testIsRemovableFalse()
    {
        $mock = $this->getMock(self::PRODUCT_FQDN);
        $this->model->addProduct($mock);
        $got  = $this->model->isRemovable();

        $this->assertInternalType(
            'bool',
            $got
        );

        $this->assertEquals(
            false,
            $got
        );
    }


    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testAddInvalidProduct()
    {
        $this->model->addProduct(1);
    }


    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testRemoveInvalidProduct()
    {
        $this->model->removeProduct(1);
    }
}
