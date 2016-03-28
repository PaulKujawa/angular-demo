<?php

namespace Barra\RestBundle\Tests\Controller;

use Barra\RecipeBundle\DataFixtures\ORM\LoadCookingData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadRecipeData;
use Barra\RecipeBundle\DataFixtures\ORM\LoadUserData;
use FOS\RestBundle\Util\Codes;
use Liip\FunctionalTestBundle\Test\WebTestCase as WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

class CookingControllerTest extends WebTestCase
{
    private $appType = ['CONTENT_TYPE' => 'application/json'];

    /** @var  Client */
    protected $client;

    /**
     * Login with credentials to receive JWT and attach it as future request http_auth header
     */
    public function setUp()
    {
        $this->loadFixtures([LoadUserData::class, LoadRecipeData::class, LoadCookingData::class]);
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
        $this->client->request('GET', '/en/api/recipes/1/cookings/new');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"children":{"description":[]}}}');
    }

    public function testGet()
    {
        $this->client->request('GET', '/en/api/recipes/1/cookings/1');
        $this->validateResponse(Codes::HTTP_OK, '{"data":{"description":"1th step","id":1,"position":1}}');

        $this->client->request('GET', '/en/api/recipes/2/cookings/1');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testCget()
    {
        $this->client->request('GET', '/en/api/recipes/1/cookings');
        $this->validateResponse(
            Codes::HTTP_OK,
            '{"data":[' .
                '{"description":"1th step","id":1,"position":1},' .
                '{"description":"2th step","id":2,"position":2},' .
                '{"description":"3th step","id":3,"position":3}' .
            ']}'
        );
    }

    public function testPost()
    {
        $requestBody = '{"cooking":{"description":"new step"}}';
        $this->client->request('POST', '/en/api/recipes/1/cookings', [], [], $this->appType, $requestBody);

        $this->validateResponse(Codes::HTTP_CREATED);
        $this->assertStringEndsWith('/en/api/recipes/1/cookings/4', $this->client->getResponse()->headers->get('Location'));
    }

    public function testPostInvalid()
    {
        $this->client->request('POST', '/en/api/recipes/1/cookings', [], [], $this->appType, '{}');
        $this->validateResponse(Codes::HTTP_BAD_REQUEST, '{"data":{"children":{"description":[]}}}');
    }

    public function testPut()
    {
        $requestBody = '{"cooking":{"description":"updated step"}}';
        $this->client->request('PUT', '/en/api/recipes/1/cookings/1', [], [], $this->appType, $requestBody);
        $this->validateResponse(Codes::HTTP_NO_CONTENT);
        $this->assertStringEndsWith('/en/api/recipes/1/cookings/1', $this->client->getResponse()->headers->get('Location'));

        $this->client->request('PUT', '/en/api/recipes/2/cookings/1', [], [], $this->appType, '{}');
        $this->validateResponse(Codes::HTTP_NOT_FOUND);
    }

    public function testDelete()
    {
        $this->client->request('DELETE', '/en/api/recipes/1/cookings/1');
        $this->validateResponse(Codes::HTTP_NO_CONTENT);

        $this->client->request('DELETE', '/en/api/recipes/2/cookings/1');
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
