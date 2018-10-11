<?php

namespace App\Tests\Controller\SecurityController;

use App\Tests\Controller\LoginTestCase;

class WrongLoginTest extends LoginTestCase {

    const REDIRECT_URI = '/login';

    const USERNAME = 'test';
    const PASSWORD = 'test';

    public function setUp() {
        parent::setUp();

        $this->username = self::USERNAME;
        $this->password = self::PASSWORD;

        $this->redirectUri = self::REDIRECT_URI;
    }

    public function testWrongLogin() {
        $crawler = $this->client->request(self::METHOD, self::URI);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $errorTagFilter = '.inner div';
        $this->assertWrongFormSubmitWithErrorMessage($crawler, $errorTagFilter);
    }
}