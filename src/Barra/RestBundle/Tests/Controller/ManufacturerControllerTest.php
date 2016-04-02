<?php

namespace Barra\RestBundle\Tests\Controller;

use Barra\RecipeBundle\DataFixtures\ORM\LoadManufacturerData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadProductData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadUserData;
use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class ManufacturerControllerTest extends WebTestCase
{
    private $appType = ['CONTENT_TYPE' => 'application/json'];

    /** @var  Client */
    protected $client;

    /**
     * Login with credentials to receive JWT and attach it as future request http_auth header
     */
    public function setUp()
    {
        $this->loadFixtures([LoadUserData::class, LoadManufacturerData::class]);

        $this->client = static::createClient();
        $this->client->request('POST', '/en/admino/login_check', ['_username' => 'demoSA', '_password' => 'testo']);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->client->setServerParameter('HTTP_Authorization', 'Bearer ' . $response['token']);
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
            '{"data":[' .
                '{"id":1,"name":"Manufacturer1"},' .
                '{"id":2,"name":"Manufacturer2"}' .
            ']}'
        );

        $this->client->request('GET', '/en/api/manufacturers');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST);
    }

    public function testGetProducts()
    {
        $this->loadFixtures([
            LoadUserData::class,
            LoadManufacturerData::class,
            LoadProductData::class,
        ]);

        $this->client->request('GET', '/en/api/manufacturers/1/products');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":[' .
                '{' .
                    '"vegan":false,"gr":1,"kcal":1,"protein":1,"carbs":1,' .
                    '"sugar":1,"fat":1,"gfat":1,"id":1,"name":"Product1"' .
                '},{' .
                    '"vegan":true,"gr":1,"kcal":1,"protein":1,"carbs":1,' .
                    '"sugar":1,"fat":1,"gfat":1,"id":2,"name":"Product2"' .
                '},{' .
                    '"vegan":true,"gr":1,"kcal":1,"protein":1,"carbs":1,' .
                    '"sugar":1,"fat":1,"gfat":1,"id":3,"name":"Product3"' .
                '},{' .
                    '"vegan":true,"gr":1,"kcal":1,"protein":1,"carbs":1,' .
                    '"sugar":1,"fat":1,"gfat":1,"id":4,"name":"Product4"' .
                '}' .
            ']}'
        );

        $this->client->request('GET', '/en/api/manufacturers/0/products');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testPost()
    {
        $requestBody = '{"manufacturer":{"name":"Manufacturer4"}}';
        $this->client->request('POST', '/en/api/manufacturers', [], [], $this->appType, $requestBody);

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/en/api/manufacturers/4', $this->client->getResponse()->headers->get('Location'));
    }

    public function testPostInvalid()
    {
        $this->client->request('POST', '/en/api/manufacturers', [], [], $this->appType, '{}');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"name":[]}}}');
    }

    public function testPut()
    {
        $requestBody = '{"manufacturer":{"name":"updated"}}';
        $this->client->request('PUT', '/en/api/manufacturers/1', [], [], $this->appType, $requestBody);
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/en/api/manufacturers/1', $this->client->getResponse()->headers->get('Location'));

        $this->client->request('PUT', '/en/api/manufacturers/0', [], [], $this->appType, '{}');
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
        $this->loadFixtures([LoadUserData::class, LoadManufacturerData::class, LoadProductData::class]);
        $this->client->request('DELETE', '/en/api/manufacturers/1');
        $this->validateResponse(Codes::HTTP_CONFLICT);
    }

    /**
     * @param int $expectedStatusCode
     * @param null|string $expectedJSON
     */
    protected function validateResponse($expectedStatusCode, $expectedJSON = null)
    {
        $this->assertEquals($expectedStatusCode, $this->client->getResponse()->getStatusCode());

        if (null !== $expectedJSON) {
            $this->assertEquals($expectedJSON, $this->client->getResponse()->getContent());
        }
    }
}
