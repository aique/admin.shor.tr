<?php

namespace App\Tests\Controller\ApiController;

class FrontNonexistentUrlRequestTest extends FrontUrlRequestTestCase {

    const SHORT_LINK = 'test';

    public function setUp() {
        $this->client = self::createClient();
    }

    public function testNonexistentUrlRequest() {
        $this->client->request(self::METHOD, self::URI.self::SHORT_LINK);
        $this->assertTrue($this->client->getResponse()->isClientError());
    }
}