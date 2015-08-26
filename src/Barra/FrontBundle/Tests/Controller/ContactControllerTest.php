<?php

namespace Main\DefaultBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * http://symfony.com/doc/current/book/testing.html
     */
    public function testIndex()
    {
        // test initial markup
        $client = static::createClient();
        $client->followRedirects();
        $crawler = $client->request('GET', '/de/contact');

        // submit valid contact form
        $form = $crawler->selectButton('form[submit]')->form([
            'form[name]'    => 'Lucas',
            'form[email]'   => 'test@googlemail.com',
            'form[message]' => 'Hey there!',
        ]);
        $crawler = $client->submit($form);
        $this->assertCount(1, $crawler->filter('.alert-success'));



        // submit invalid contact form
        $form = $crawler->selectButton('form[submit]')->form([
            'form[name]'    => 'Lucas',
            'form[email]'   => 'invalidEmailAdress',
            'form[message]' => 'Hey there!',
        ]);
        $crawler = $client->submit($form);
        $this->assertCount(0, $crawler->filter('.alert-success'));




        //$this->assertGreaterThan(0, $crawler->filter('a')->count());
        //$this->assertCount(4, $crawler->filter('a'));
        //$this->assertTrue($crawler->filter('#form_name')->count() > 0);
        //$this->assertTrue($crawler->filter('.error_list')->count() == 0);

        /* use link
        $link = $crawler->filter('a:contains("referenzen")')->eq(0)->link(); // XPath or CSS possible
        $crawler = $client->click($link);

        // forms
        $form = $crawler->selectButton('submit')->form();
        $form['name'] = 'Lucas';
        $form['form_name[subject]'] = 'Hey there!';
        $crawler = $client->submit($form);
        */
    }
}
