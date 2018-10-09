<?php

namespace App\Tests\Controller\DefaultController;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class SuccessLoginTest extends WebTestCase {

    const URI = '/login';
    const METHOD = 'GET';

    /** @var Client */
    private $client;

    public function setUp() {
        parent::setUp();
        $this->client = self::createClient();
    }

    public function testSuccessLogin() {
        $crawler = $this->client->request(self::METHOD, self::URI);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertFormSubmit($crawler);
    }

    private function assertFormSubmit(Crawler $crawler) {
        $form = $crawler->filter('.btn-default')->form();

        $form['_username'] = 'aique';
        $form['_password'] = 'aique';

        $this->client->submit($form);

        $this->client->followRedirect();

        $this->assertTrue($this->client->getResponse()->isRedirection());
        $this->assertContains('/admin', $this->client->getHistory()->current()->getUri());
    }
}