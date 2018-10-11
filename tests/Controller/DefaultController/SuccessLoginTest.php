<?php

namespace App\Tests\Controller\DefaultController;

class SuccessLoginTest extends LoginTestCase {

    const URI = '/login';
    const REDIRECT_URI = '/admin';
    const METHOD = 'GET';

    const USERNAME = 'aique';
    const PASSWORD = 'aique';

    public function setUp() {
        parent::setUp();

        $this->username = self::USERNAME;
        $this->password = self::PASSWORD;

        $this->redirectUri = self::REDIRECT_URI;
    }

    public function testSuccessLogin() {
        $crawler = $this->client->request(self::METHOD, self::URI);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertSuccessFormSubmit($crawler);
    }
}