<?php

namespace App\Tests\Controller\DefaultController;

abstract class LoginTestCase extends SignFormSubmitCase {

    const URI = '/login';
    const METHOD = 'GET';
    const ERROR_LOGIN_MESSAGE = 'Invalid credentials';

    protected $username;
    protected $password;

    public function setUp() {
        parent::setUp();

        $this->errorMessage = self::ERROR_LOGIN_MESSAGE;
    }

    protected function fillFormData() {
        return [
            '_username' => $this->username,
            '_password' => $this->password
        ];
    }
}