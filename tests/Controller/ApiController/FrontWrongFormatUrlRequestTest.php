<?php

namespace App\Tests\Controller\ApiController;

class FrontWrongFormatUrlRequestTest extends FrontUrlRequestTestCase {

    const SHORT_LINK = '%test%';

    public function setUp() {
        $this->client = self::createClient();
    }

    public function testWrongFormatUrlRequest() {
        $this->client->request(self::METHOD, self::URI.self::SHORT_LINK);
        $this->assertTrue($this->client->getResponse()->isClientError());
    }
}