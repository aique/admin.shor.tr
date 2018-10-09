<?php

namespace App\Tests\Controller\DefaultController;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;

class IndexTest extends WebTestCase {

    const URI = '/';
    const METHOD = 'GET';

    const INDEX_TITLE = 'Shor.tr';

    /** @var Client */
    private $client;

    public function setUp() {
        parent::setUp();
        $this->client = self::createClient();
    }

    public function testIndex() {
        $crawler = $this->client->request(self::METHOD, self::URI);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertContent($crawler);
        $this->assertNavLinks($crawler);
    }

    private function assertContent(Crawler $crawler) {
        $this->assertEquals(self::INDEX_TITLE, $crawler->filter('.cover-heading')->text());
    }

    private function assertNavLinks(Crawler $crawler) {
        $numLinks = $crawler->filter('.nav-link')->count();

        for ($i = 0 ; $i < $numLinks ; $i++) {
            $navLink = $crawler->filter('.nav-link')->eq($i)->link();
            $this->client->click($navLink);
            $this->assertTrue($this->client->getResponse()->isSuccessful());
        }
    }
}