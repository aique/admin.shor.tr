<?php

namespace App\Tests\Entity;

use App\Entity\LinkRequestStats;
use App\Entity\ShortLink;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ShortLinkTest extends TestCase {

    const ID = 1;
    const URL = 'b';

    const USER_NAME = 'aique';
    const USER_EMAIL = 'aique@mail.com';

    private $stats;

    /** @var User */
    private $user;

    /** @var ShortLink */
    private $shortLink;

    public function setUp() {
        $this->stats = [
            new LinkRequestStats()
        ];

        $this->user = new User(
            self::USER_NAME,
            self::USER_EMAIL
        );

        $this->shortLink = new ShortLink();

        $this->shortLink->setId(self::ID);
        $this->shortLink->setUrl(self::URL);
        $this->shortLink->setUser($this->user);
        $this->shortLink->setStats($this->stats);
    }

    public function testShortLink() {
        $this->assertEquals(self::ID, $this->shortLink->getId());
        $this->assertEquals(self::URL, $this->shortLink->getUrl());
        $this->assertEquals($this->user, $this->shortLink->getUser());
        $this->assertEquals($this->stats, $this->shortLink->getStats());
        $this->assertEquals(self::URL, $this->shortLink->__toString());
    }
}