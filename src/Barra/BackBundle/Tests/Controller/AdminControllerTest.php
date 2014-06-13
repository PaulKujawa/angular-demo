<?php

namespace Barra\BackBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admino/');


        $this->assertGreaterThan(2, $crawler->filter('h2')->count(), 'Adminsite is not accessable');

        // $crawler = $client->click($crawler->selectLink('Create a new entry')->link());
        //$crawler = $client->click( $crawler->filter('a:contains("References")')->eq(1)->link() );


        // $this->assertGreaterThan(0, $crawler->filter('h1')->count());
    }
}
