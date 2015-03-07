<?php

namespace Barra\RestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals($statusCode, $response->getStatusCode(), $response->getContent());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    public function testGetRecipe()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/api/recipes');
        $response = $client->getResponse();
        $this->assertJsonResponse($response, 200);
    }

    public function testGetRecipes()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/api/recipes/1');
        $response = $client->getResponse();
        $this->assertJsonResponse($response, 200);
    }

    public function testGetRecipesLimited()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/api/recipes/limited');
        $response = $client->getResponse();
        $this->assertJsonResponse($response, 200);
        // todo ?offset=2&limit=3
    }

    public function testPostRecipe()
    {

    }

    public function testPutRecipe()
    {

    }

    public function testDeleteRecipe()
    {

    }
}