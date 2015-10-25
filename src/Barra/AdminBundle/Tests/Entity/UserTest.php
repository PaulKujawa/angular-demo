<?php

namespace Barra\FrontBundle\Tests\Entity;

use Barra\AdminBundle\Entity\Reference;
use Barra\AdminBundle\Entity\User;

/**
 * Class UserTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\FrontBundle\Tests\Entity
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    const SELF_FQDN                 = 'Barra\AdminBundle\Entity\User';
    const ID                        = 2;


    /** @var  User */
    protected $model;


    public function setUp()
    {
        $this->model = new User();
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
}
