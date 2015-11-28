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
        $this->assertEquals(self::ID, $got);
    }

    /**
     * @return Manufacturer
     */
    public function testSetName()
    {
        $resource = $this->model->setName(self::NAME);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

        return $resource;
    }

    /**
     * @depends testSetName
     * @param Manufacturer $self
     */
    public function testGetName(Manufacturer $self)
    {
        $this->assertEquals(self::NAME, $self->getName());
    }

    /**
     * @return Manufacturer
     */
    public function testAddProduct()
    {
        $mock     = $this->getMock(self::PRODUCT_FQDN);
        $resource = $this->model->addProduct($mock);
        $this->assertInstanceOf(self::SELF_FQDN, $resource);

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
        $this->assertCount(1, $products);
        $product   = $products[0];

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
        $this->assertInstanceOf(self::SELF_FQDN, $resource);
        $this->assertCount(0, $self->getProducts());
    }

    public function testIsRemovable()
    {
        $this->assertTrue($this->model->isRemovable());

        $mock = $this->getMock(self::PRODUCT_FQDN);
        $this->model->addProduct($mock);
        $this->assertFalse($this->model->isRemovable());
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testAddInvalidProduct()
    {
        $this->model->addProduct(1);
    }

    /**
     * @expectedException \PHPUnit_Framework_Error
     */
    public function testRemoveInvalidProduct()
    {
        $this->model->removeProduct(1);
    }
}
