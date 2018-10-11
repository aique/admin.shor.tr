<?php

namespace App\Tests\Controller\DefaultController;

class SuccessRegisterTestCase extends RegisterTestCase {

    const REDIRECT_URI = '/register';

    const USERNAME = 'maria';
    const EMAIL = 'maria@mail.com';
    const PASSWORD = 'maria';

    public function setUp() {
        parent::setUp();

        $this->redirectUri = self::REDIRECT_URI;

        $this->username = self::USERNAME;
        $this->email = self::EMAIL;
        $this->password = self::PASSWORD;
    }

    public function testEmptyUsernameRegister() {
        $this->username = '';
        $this->assertWrongRegister();
    }

    public function testInvalidMinLengthUsernameRegister() {
        $this->username = 'a';
        $this->assertWrongRegister();
    }

    public function testInvalidMaxLengthUsernameRegister() {
        $this->username = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $this->assertWrongRegister();
    }

    public function testInvalidCharactersUsernameRegister() {
        $this->username = '%maria%';
        $this->assertWrongRegister();
    }

    public function testEmptyEmailRegister() {
        $this->email = '';
        $this->assertWrongRegister();
    }

    public function testInvalidEmailRegister() {
        $this->email = 'maria@mail';
        $this->assertWrongRegister();
    }

    public function testEmptyPasswordRegister() {
        $this->email = '';
        $this->assertWrongRegister();
    }

    public function testInvalidMinLengthPasswordRegister() {
        $this->email = 'a';
        $this->assertWrongRegister();
    }

    public function testInvalidMaxLengthPasswordRegister() {
        $this->email = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $this->assertWrongRegister();
    }

    private function assertWrongRegister() {
        $crawler = $this->client->request(self::METHOD, self::URI);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertWrongFormSubmit($crawler);
    }
}