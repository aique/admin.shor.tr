<?php

namespace App\Tests\Controller\DefaultController;

abstract class RegisterTestCase extends SignFormSubmitCase {

    const URI = '/register';
    const METHOD = 'GET';

    protected $username;
    protected $email;
    protected $password;

    protected function fillFormData() {
        return [
            '_username' => $this->username,
            '_email' => $this->email,
            '_password' => $this->password
        ];
    }
}