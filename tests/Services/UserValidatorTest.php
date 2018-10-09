<?php

namespace App\Tests\Services;

use App\Entity\User;
use App\Services\Validation\UserValidator;
use PHPUnit\Framework\TestCase;

class UserValidatorTest extends TestCase
{
    private $invalidUsers;
    private $validUsers;

    /** @var UserValidator */
    private $validator;

    public function setUp() {
        $this->validator = new UserValidator();

        $this->validUsers = [
            new User('aique', 'aique@mail.com', 'aique')
        ];

        $this->invalidUsers = [
            new User('a', 'aique@mail.com', 'aique'),
            new User('aique', 'a', 'aique'),
            new User('aique', 'aique@mail.com', 'a'),
            new User('aique', 'aique@mail', 'aique'),
            new User('aique!@#', 'aique@mail.com', 'aique'),
            new User('aique', 'aique@mail.com', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa')
        ];
    }

    public function testValidUsers() {
        foreach($this->validUsers as $validUser) {
            $this->assertTrue($this->validator->validate($validUser));
        }
    }

    public function testInvalidUsers()
    {
        foreach($this->invalidUsers as $invalidUser) {
            $this->assertFalse($this->validator->validate($invalidUser));
        }
    }
}
