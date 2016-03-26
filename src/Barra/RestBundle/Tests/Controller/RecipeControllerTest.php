<?php

namespace Barra\RestBundle\Tests\Controller;

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
        $this->loadFixtures([
            'Barra\RecipeBundle\DataFixtures\ORM\LoadUserData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadRecipeData',
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

    public function testCount()
    {
        $this->client->request('GET', '/en/api/recipes/count');
        $this->validateResponse(Codes::HTTP_OK, '{"data":"3"}');
    }

    public function testGetIngredients()
    {
        $this->loadFixtures([
            'Barra\RecipeBundle\DataFixtures\ORM\LoadUserData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadManufacturerData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadMeasurementData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadRecipeData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadProductData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadIngredientData',
        ]);

        $this->client->request('GET', '/en/api/recipes/1/ingredients');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":[' .
                '{"amount":1,"id":1,"position":1},' .
                '{"amount":2,"id":2,"position":2}' .
            ']}'
        );

        $this->client->request('GET', '/en/api/recipes/0/ingredients');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testGetCookings()
    {
        $this->loadFixtures([
            'Barra\RecipeBundle\DataFixtures\ORM\LoadUserData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadRecipeData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadCookingData',
        ]);

        $this->client->request('GET', '/en/api/recipes/1/cookings');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":[' .
                '{"description":"1th step","id":1,"position":1},' .
                '{"description":"2th step","id":2,"position":2},' .
                '{"description":"3th step","id":3,"position":3}' .
            ']}'
        );

        $this->client->request('GET', '/en/api/recipes/0/cookings');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testGetPhotos()
    {
        $this->loadFixtures([
            'Barra\RecipeBundle\DataFixtures\ORM\LoadUserData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadRecipeData',
            'Barra\RecipeBundle\DataFixtures\ORM\LoadPhotoData',
        ]);

        $this->client->request('GET', '/en/api/recipes/1/photos');
        preg_match(
            "/.*\"filename\":\"(.*jpeg).*\"filename\":\"(.*jpeg)/",
            $this->client->getResponse()->getContent(), $matches
        );

        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":[' .
                '{"path":"images\/uploads","id":1,"filename":"' . $matches[1] . '","size":145263},' .
                '{"path":"images\/uploads","id":2,"filename":"' . $matches[2] . '","size":145263}' .
            ']}'
        );

        $this->client->request('GET', '/en/api/recipes/0/photos');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
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
