<?php

namespace Barra\RestBundle\Tests\Controller;

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
            'Barra\RecipeBundle\DataFixtures\ORM\LoadUserData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadManufacturerData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadMeasurementData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadRecipeData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadProductData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadIngredientData',
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
        $this->client->request('GET', '/en/api/ingredients/new');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":{"children":{"amount":[],"measurement":[],"product":[],"recipe":[]}}}'
        );
    }

    public function testGet()
    {
        $this->client->request('GET', '/en/api/ingredients/1');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"amount":1,"id":1,"position":1}}');

        $this->client->request('GET', '/en/api/ingredients/0');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testCget()
    {
        $this->client->request('GET', '/en/api/ingredients?limit=2');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":[' .
                '{"amount":1,"id":1,"position":1},' .
                '{"amount":2,"id":2,"position":2}' .
            ']}'
        );

        $this->client->request('GET', '/en/api/ingredients');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST);
    }

    public function testCount()
    {
        $this->client->request('GET', '/en/api/ingredients/count');
        $this->validateResponse(Codes::HTTP_OK, '{"data":"3"}');
    }

    public function testGetProduct()
    {
        $this->client->request('GET', '/en/api/ingredients/1/product');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":{' .
                '"vegan":false,"gr":1,"kcal":1,"protein":1,"carbs":1,' .
                '"sugar":1,"fat":1,"gfat":1,"id":1,"name":"Product1"' .
            '}}'
        );

        $this->client->request('GET', '/en/api/ingredients/0/product');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testGetMeasurement()
    {
        $this->client->request('GET', '/en/api/ingredients/1/measurement');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"gr":1,"id":1,"name":"gr"}}');

        $this->client->request('GET', '/en/api/ingredients/0/measurement');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testGetRecipe()
    {
        $this->client->request('GET', '/en/api/ingredients/1/recipe');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"id":1,"name":"Recipe1"}}');

        $this->client->request('GET', '/en/api/ingredients/0/recipe');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testPost()
    {
        $requestBody = '{"ingredient":{"amount":1,"measurement":1,"product":4,"recipe":1}}';
        $this->client->request('POST', '/en/api/ingredients', [], [], $this->appType, $requestBody);

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/en/api/ingredients/4', $this->client->getResponse()->headers->get('Location'));
    }

    public function testPostInvalid()
    {
        $this->client->request('POST', '/en/api/ingredients', [], [], $this->appType, '{}');
        $this->validateResponse(
            Codes::HTTP_BAD_REQUEST,
            '{"data":{"children":{"amount":[],"measurement":[],"product":[],"recipe":[]}}}'
        );

        $this->client->request('POST', '/en/api/ingredients', [], [], $this->appType, '{"ingredient":{"recipe":0}}');
        $this->validateResponse(
            Codes::HTTP_BAD_REQUEST,
            '{"data":{"children":{"amount":[],"measurement":[],"product":[],"recipe":[]}}}'
        );
    }

    public function testPut()
    {
        $requestBody = '{"ingredient":{"amount":1,"measurement":1,"product":4,"recipe":1}}';
        $this->client->request('PUT', '/en/api/ingredients/1', [], [], $this->appType, $requestBody);
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/en/api/ingredients/1', $this->client->getResponse()->headers->get('Location'));

        $this->client->request('PUT', '/en/api/ingredients/0', [], [], $this->appType, '{}');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testDelete()
    {
        $this->client->request('DELETE', '/en/api/ingredients/1');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/en/api/ingredients/0');
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
