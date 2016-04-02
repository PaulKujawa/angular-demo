<?php

namespace Barra\RestBundle\Tests\Controller;

use Barra\RecipeBundle\DataFixtures\ORM\LoadCookingData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadIngredientData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadManufacturerData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadMeasurementData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadPhotoData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadProductData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadRecipeData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadUserData;
use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class RecipeControllerTest extends WebTestCase
{
    private $appType = ['CONTENT_TYPE' => 'application/json'];

    /** @var  Client */
    protected $client;

    /**
     * Login with credentials to receive JWT and attach it as future request http_auth header
     */
    public function setUp()
    {
        $this->loadFixtures([LoadUserData::class, LoadRecipeData::class]);

        $this->client = static::createClient();
        $this->client->request('POST', '/en/admino/login_check', ['_username' => 'demoSA', '_password' => 'testo']);

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->client->setServerParameter('HTTP_Authorization', 'Bearer ' . $response['token']);
    }

    public function testNew()
    {
        $this->client->request('GET', '/en/api/recipes/new');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"children":{"name":[]}}}');
    }

    public function testGet()
    {
        $this->client->request('GET', '/en/api/recipes/1');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"id":1,"name":"Recipe1"}}');

        $this->client->request('GET', '/en/api/recipes/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testCget()
    {
        $this->client->request('GET', '/en/api/recipes?limit=2');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":[' .
                '{"id":1,"name":"Recipe1"},' .
                '{"id":2,"name":"Recipe2"}' .
            ']}'
        );

        $this->client->request('GET', '/en/api/recipes');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST);
    }

    public function testPost()
    {
        $this->client->request('POST', '/en/api/recipes', [], [], $this->appType, '{"recipe":{"name":"Recipe4"}}');

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/en/api/recipes/4', $this->client->getResponse()->headers->get('Location'));
    }

    public function testPostInvalid()
    {
        $this->client->request('POST', '/en/api/recipes', [], [], $this->appType, '{}');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"name":[]}}}');
    }

    public function testPut()
    {
        $this->client->request('PUT', '/en/api/recipes/1', [], [], $this->appType, '{"recipe":{"name":"updated"}}');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/en/api/recipes/1', $this->client->getResponse()->headers->get('Location'));

        $this->client->request('PUT', '/en/api/recipes/0', [], [], $this->appType, '{}');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testDelete()
    {
        $this->client->request('DELETE', '/en/api/recipes/1');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/en/api/recipes/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
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
