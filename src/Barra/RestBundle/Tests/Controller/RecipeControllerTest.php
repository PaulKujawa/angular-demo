<?php

namespace Barra\RestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use FOS\RestBundle\Util\Codes;

class RecipeControllerTest extends WebTestCase
{

    public function testGetRecipe()
    {
        $client = static::createClient();
        $client->request('GET', '/api/recipes/1');
        $this->assertJsonResponse($client->getResponse());
    }


    public function testGetRecipes()
    {
        $client = static::createClient();
        $client->request('GET', '/api/recipes');
        $this->assertJsonResponse($client->getResponse());
    }


    public function testGetRecipesLimited()
    {
        $client = static::createClient();
        $client->request('GET', '/api/recipes/limited');
        $this->assertJsonResponse($client->getResponse());
        // todo ?offset=2&limit=3
    }


    public function testPostRecipe()
    {
        $client = static::createClient();
        $client->request('POST', '/api/recipes', array(), array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            '{"formRecipe":{"name":"testRecipe2"}}'
        );
       // $this->assertJsonResponse($client->getResponse(), Codes::HTTP_CREATED, false);
    }


    public function testPostRecipeUnprocessable()
    {
        $client = static::createClient();
        $client->request('POST', '/api/recipes', array(), array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            '{"formRecipe":{"name":"testRecipe2"}}'
        );
        $this->assertJsonResponse($client->getResponse(), Codes::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function testPostRecipeInvalidForm()
    {
        $client = static::createClient();
        $client->request('POST', '/api/recipes', array(), array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            '{"name":"testRecipe"}'
        );
        $this->assertJsonResponse($client->getResponse(), Codes::HTTP_BAD_REQUEST, false);
    }


    public function testPutRecipe()
    {
        $client = static::createClient();
        $client->request('PUT', '/api/recipes/19', array(), array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            '{"formRecipe":{"name":"testRecipe2"}}'
        );
        $this->assertJsonResponse($client->getResponse(), Codes::HTTP_NO_CONTENT, false);
    }


    public function testPutRecipeInvalidForm()
    {
        $client = static::createClient();
        $client->request('PUT', '/api/recipes/19', array(), array(),
            array('CONTENT_TYPE' => 'application/json', 'Accept' => 'application/json'),
            '{"name":"testRecipe2"}'
        );
        $this->assertJsonResponse($client->getResponse(), Codes::HTTP_BAD_REQUEST, false);
    }


    public function testDeleteRecipe()
    {
        $client = static::createClient();
        $client->request('DELETE', '/api/recipes/67');
        $response = $client->getResponse();
        $this->assertJsonResponse($response, Codes::HTTP_NO_CONTENT, false);
    }


    protected function assertJsonResponse($response, $statusCode = Codes::HTTP_OK, $checkValidJson = true)
    {
        $this->assertEquals($statusCode, $response->getStatusCode(), $response->getContent());
        if ($checkValidJson) {
            $this->assertTrue($response->headers->contains('content-type', 'application/json'), $response->headers);

            $decode = json_decode($response->getContent());
            $this->assertTrue(($decode != null && $decode != false), 'is response valid json: [' . $response->getContent() . ']');
        }
    }
}