<?php

namespace App\Tests\Controller\DefaultController;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class WrongLoginTest extends WebTestCase {

    const URI = '/login';
    const METHOD = 'GET';

    /** @var Client */
    private $client;

    public function setUp() {
        parent::setUp();
        $this->client = self::createClient();
    }

    public function testWrongLogin() {
        $crawler = $this->client->request(self::METHOD, self::URI);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertFormSubmit($crawler);
    }

    private function assertFormSubmit(Crawler $crawler) {
        $form = $crawler->filter('.btn-default')->form();

        $data = [
            '_username' => 'test',
            '_password' => 'test'
        ];

        $this->client->submit($form, $data);

        $crawler = $this->client->followRedirect();

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContains('/login', $this->client->getHistory()->current()->getUri());
        $this->assertContains('Invalid credentials', $crawler->filter('.inner div')->text());
    }
}