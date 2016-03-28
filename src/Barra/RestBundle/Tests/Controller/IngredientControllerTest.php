<?php

namespace Barra\RestBundle\Tests\Controller;

use Barra\RecipeBundle\DataFixtures\ORM\LoadIngredientData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadManufacturerData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadMeasurementData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadProductData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadRecipeData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadUserData;
use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class IngredientControllerTest extends WebTestCase
{
    private $appType = ['CONTENT_TYPE' => 'application/json'];

    /** @var  Client */
    protected $client;

    /**
     * Login with credentials to receive JWT and attach it as future request http_auth header
     */
    public function setUp()
    {
        $this->loadFixtures([
            LoadUserData::class,
            LoadManufacturerData::class,
            LoadMeasurementData::class,
            LoadRecipeData::class,
            LoadProductData::class,
            LoadIngredientData::class,
        ]);

        $this->client = static::createClient();
        $csrfToken = $this->client->getContainer()->get('form.csrf_provider')->generateCsrfToken('authenticate');

        $this->client->request(
            'POST',
            '/en/admino/login_check',
            [
                '_username' => 'demoSA',
                '_password' => 'testo',
                '_csrf_token' => $csrfToken,
            ]
        );

        $response = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $response);

        $this->client = static::createClient(); // without (recent/any) session
        $this->client->setServerParameter('HTTP_Authorization', 'Bearer ' . $response['token']);
    }

    public function testNew()
    {
        $this->client->request('GET', '/en/api/recipes/1/ingredients/new');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"children":{"amount":[],"measurement":[],"product":[]}}}');
    }

    public function testGet()
    {
        $this->client->request('GET', '/en/api/recipes/1/ingredients/1');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"amount":1,"id":1,"position":1}}');

        $this->client->request('GET', '/en/api/recipes/2/ingredients/1');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testCget()
    {
        $this->client->request('GET', '/en/api/recipes/1/ingredients');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":[' .
                '{"amount":1,"id":1,"position":1},' .
                '{"amount":2,"id":2,"position":2}' .
            ']}'
        );
    }

    public function testGetProduct()
    {
        $this->client->request('GET', '/en/api/recipes/1/ingredients/1/product');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":{' .
                '"vegan":false,"gr":1,"kcal":1,"protein":1,"carbs":1,' .
                '"sugar":1,"fat":1,"gfat":1,"id":1,"name":"Product1"' .
            '}}'
        );

        $this->client->request('GET', '/en/api/recipes/2/ingredients/1/product');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testGetMeasurement()
    {
        $this->client->request('GET', '/en/api/recipes/1/ingredients/1/measurement');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"gr":1,"id":1,"name":"gr"}}');

        $this->client->request('GET', '/en/api/recipes/2/ingredients/1/measurement');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testPost()
    {
        $requestBody = '{"ingredient":{"amount":1,"measurement":1,"product":4}}';
        $this->client->request('POST', '/en/api/recipes/1/ingredients', [], [], $this->appType, $requestBody);

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/en/api/recipes/1/ingredients/4', $this->client->getResponse()->headers->get('Location'));
    }

    public function testPostInvalid()
    {
        $this->client->request('POST', '/en/api/recipes/1/ingredients', [], [], $this->appType, '{}');
        $this->validateResponse(
            Codes::HTTP_BAD_REQUEST,
            '{"data":{"children":{"amount":[],"measurement":[],"product":[]}}}'
        );
    }

    public function testPut()
    {
        $requestBody = '{"ingredient":{"amount":1,"measurement":1,"product":4}}';
        $this->client->request('PUT', '/en/api/recipes/1/ingredients/1', [], [], $this->appType, $requestBody);
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/en/api/recipes/1/ingredients/1', $this->client->getResponse()->headers->get('Location'));

        $this->client->request('PUT', '/en/api/recipes/2/ingredients/1', [], [], $this->appType, '{}');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testDelete()
    {
        $this->client->request('DELETE', '/en/api/recipes/1/ingredients/1');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/en/api/recipes/2/ingredients/1');
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
