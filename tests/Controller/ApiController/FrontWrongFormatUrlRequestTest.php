<?php

namespace App\Tests\Controller\ApiController;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FrontWrongFormatUrlRequestTest extends WebTestCase {

    const URI = '/shortlink/';
    const SHORT_LINK = '%test%';
    const METHOD = 'GET';

    /** @var Client */
    private $client;

    public function setUp() {
        $this->client = self::createClient();
    }

    public function testWrongFormatUrlRequest() {
        $this->client->request(self::METHOD, self::URI.self::SHORT_LINK);
        $this->assertTrue($this->client->getResponse()->isClientError());
    }
}