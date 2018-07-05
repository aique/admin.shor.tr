<?php

namespace App\Tests;

use App\Entity\User;
use App\Services\Validation\UserValidator;
use PHPUnit\Framework\TestCase;

class UserValidatorTest extends TestCase
{
    public function testUserValidator()
    {
        $userValidator = new UserValidator();

        $user = new User('a', 'aique@mail.com', 'aique');
        $this->assertFalse($userValidator->validate($user));
        $user = new User('aique', 'a', 'aique');
        $this->assertFalse($userValidator->validate($user));
        $user = new User('aique', 'aique@mail.com', 'a');
        $this->assertFalse($userValidator->validate($user));
        $user = new User('aique', 'aique@mail', 'aique');
        $this->assertFalse($userValidator->validate($user));
        $user = new User('aique!@#', 'aique@mail.com', 'aique');
        $this->assertFalse($userValidator->validate($user));
        $user = new User('aique', 'aique@mail.com', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        $this->assertFalse($userValidator->validate($user));
    }
}
