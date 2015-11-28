<?php

namespace Barra\RestBundle\Tests\Controller;

use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Class ManufacturerControllerTest
 * @author Paul Kujawa <p.kujawa@gmx.net>
 * @package Barra\RestBundle\Tests\Controller
 */
class ManufacturerControllerTest extends WebTestCase
{
    /** @var  Client */
    protected $client;

    /**
     * Login with credentials to receive JWT and attach it as future request http_auth header
     */
    public function setUp()
    {
        $this->loadFixtures([
            'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadManufacturerData',
        ]);

        $this->client = static::createClient();
        $csrfToken    = $this->client
            ->getContainer()
            ->get('form.csrf_provider')
            ->generateCsrfToken('authenticate');

        $this->client->request(
            'POST',
            '/de/admino/login_check',
            [
                '_username'     => 'demoSA',
                '_password'     => 'testo',
                '_csrf_token'   => $csrfToken,
            ]
        );

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);

        $this->client = static::createClient(); // without (recent/any) session
        $this->client->setServerParameter('HTTP_Authorization', 'Bearer '.$response['token']);
    }

    public function testNew()
    {
        $this->client->request('GET', '/en/api/manufacturers/new');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"children":{"name":[]}}}');
    }

    public function testGet()
    {
        $this->client->request('GET', '/en/api/manufacturers/1');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"id":1,"name":"Manufacturer1"}}');

        $this->client->request('GET', '/en/api/manufacturers/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testCget()
    {
        $this->client->request('GET', '/en/api/manufacturers?limit=2');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{"id":1,"name":"Manufacturer1"},'.
                '{"id":2,"name":"Manufacturer2"}'.
            ']}'
        );

        $this->client->request('GET', '/en/api/manufacturers');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST);
    }

    public function testGetProducts()
    {
        $this->loadFixtures(
            [
                'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
                'Barra\AdminBundle\DataFixtures\ORM\LoadManufacturerData',
                'Barra\AdminBundle\DataFixtures\ORM\LoadProductData',
            ]
        );

        $this->client->request('GET', '/en/api/manufacturers/1/products');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":['.
                '{'.
                    '"vegan":false,"gr":1,"kcal":1,"protein":1,"carbs":1,'.
                    '"sugar":1,"fat":1,"gfat":1,"id":1,"name":"Product1"'.
                '},{'.
                    '"vegan":true,"gr":1,"kcal":1,"protein":1,"carbs":1,'.
                    '"sugar":1,"fat":1,"gfat":1,"id":2,"name":"Product2"'.
                '},{'.
                    '"vegan":true,"gr":1,"kcal":1,"protein":1,"carbs":1,'.
                    '"sugar":1,"fat":1,"gfat":1,"id":3,"name":"Product3"'.
                '},{'.
                    '"vegan":true,"gr":1,"kcal":1,"protein":1,"carbs":1,'.
                    '"sugar":1,"fat":1,"gfat":1,"id":4,"name":"Product4"'.
                '}'.
            ']}'
        );

        $this->client->request('GET', '/en/api/manufacturers/0/products');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testPost()
    {
        $this->client->request(
            'POST',
            '/en/api/manufacturers',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formManufacturer":{"name":"Manufacturer4"}}'
        );

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/en/api/manufacturers/4', $this->client->getResponse()->headers->get('Location'));
    }

    public function testPostInvalid()
    {
        $this->client->request(
            'POST',
            '/en/api/manufacturers',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"name":[]}}}');
    }

    public function testPut()
    {
        $this->client->request(
            'PUT',
            '/en/api/manufacturers/1',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"formManufacturer":{"name":"updated"}}'
        );
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/en/api/manufacturers/1', $this->client->getResponse()->headers->get('Location'));

        $this->client->request(
            'PUT',
            '/en/api/manufacturers/0',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{}'
        );
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testDelete()
    {
        $this->client->request('DELETE', '/en/api/manufacturers/1');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/en/api/manufacturers/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testDeleteInvalid()
    {
        $this->loadFixtures([
            'Barra\AdminBundle\DataFixtures\ORM\LoadUserData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadManufacturerData',
            'Barra\AdminBundle\DataFixtures\ORM\LoadProductData',
        ]);

        $this->client->request('DELETE', '/en/api/manufacturers/1');
        $this->validateResponse(Codes::HTTP_CONFLICT);
    }

    /**
     * @param int           $expectedStatusCode
     * @param null|string   $expectedJSON
     */
    protected function validateResponse($expectedStatusCode, $expectedJSON = null)
    {
        $this->assertEquals(
            $expectedStatusCode,
            $this->client->getResponse()->getStatusCode()
        );

        if (null !== $expectedJSON) {
            $this->assertEquals(
                $expectedJSON,
                $this->client->getResponse()->getContent()
            );
        }
    }
}