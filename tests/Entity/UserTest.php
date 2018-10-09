<?php

namespace App\Tests\Entity;

use App\Entity\ShortLink;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase {

    const USERNAME = 'aique';
    const EMAIL = 'aique@mail.com';
    const PASS = 'aique';
    const REGISTERED_AT = '2018-05-05 00:00:00';

    private $shortLinks;

    private $registeredAt;

    /** @var User */
    private $user;

    public function setUp() {
        $this->shortLinks = [
            new ShortLink()
        ];

        $this->registeredAt = \DateTime::createFromFormat('Y-m-d H:i:s', self::REGISTERED_AT);

        $this->user = new User(
            self::USERNAME,
            self::EMAIL,
            self::PASS
        );

        $this->user->setRegisteredAt($this->registeredAt);
        $this->user->setPassword(self::PASS);
        $this->user->setIsAdmin(true);
        $this->user->setShortLinks($this->shortLinks);
    }

    public function testUser() {
        $this->assertEquals(self::USERNAME, $this->user->getUsername());
        $this->assertEquals(self::EMAIL, $this->user->getEmail());
        $this->assertEquals(self::PASS, $this->user->getPlainPassword());
        $this->assertEquals($this->registeredAt, $this->user->getRegisteredAt());
        $this->assertEquals(self::PASS, $this->user->getPassword());
        $this->assertTrue($this->user->getIsAdmin());
        $this->assertEquals($this->shortLinks, $this->user->getShortLinks());
        $this->assertEquals(self::USERNAME, $this->user->__toString());
        $this->assertEquals(['ROLE_ADMIN'], $this->user->getRoles());
    }

    public function testConstructorParamSetters() {
        $newUsername = 'manuel';
        $newEmail = 'manuel@mail.com';
        $newPass = 'manuel';

        $this->user->setUsername($newUsername);
        $this->user->setEmail($newEmail);
        $this->user->setPlainPassword($newPass);

        $this->assertEquals($newUsername, $this->user->getUsername());
        $this->assertEquals($newEmail, $this->user->getEmail());
        $this->assertEquals($newPass, $this->user->getPlainPassword());
    }
}