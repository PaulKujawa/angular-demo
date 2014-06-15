<?php

namespace Barra\BackBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admino/');

        $this->assertGreaterThan(2, $crawler->filter('h1')->count(), 'Adminsite is not accessable');
        $crawler = $client->click( $crawler->selectLink('References')->link() );
        $this->assertCount(1, $crawler->filter('h1'), 'reference is not accessable');
        $this->assertTrue($client->getResponse()->isSuccessful());

        //$crawler = $client->click( $crawler->filter('a:contains("References")')->eq(1)->link() );
    }
}
