<?php

namespace App\Tests\Entity;

use App\Entity\LinkRequestStats;
use App\Entity\ShortLink;
use PHPUnit\Framework\TestCase;

class LinkRequestStatsTest extends TestCase {

    const ID = 1;
    const CREATED_AT = '2018-06-06 00:00:00';
    const IP = '192.168.1.1';
    const DEVICE = LinkRequestStats::MOBILE_DEVICE;
    const REFERER = 'http://youtube.com';

    const SHORT_LINK_ID = 1;
    const SHORT_LINK_URL = 'b';

    /** @var ShortLink */
    private $shortLink;

    private $createdAt;

    /** @var LinkRequestStats */
    private $linkRequestStats;

    public function setUp() {
        $this->shortLink = new ShortLink();
        $this->shortLink->setId(self::SHORT_LINK_ID);
        $this->shortLink->setUrl(self::SHORT_LINK_URL);

        $this->createdAt = \DateTime::createFromFormat('Y-m-d H:i:s', self::CREATED_AT);

        $this->linkRequestStats = new LinkRequestStats();

        $this->linkRequestStats->setId(self::ID);
        $this->linkRequestStats->setCreatedAt($this->createdAt);
        $this->linkRequestStats->setIp(self::IP);
        $this->linkRequestStats->setDevice(self::DEVICE);
        $this->linkRequestStats->setReferer(self::REFERER);
        $this->linkRequestStats->setShortLink($this->shortLink);
    }

    public function testLinkRequestStats() {
        $this->assertEquals(self::ID, $this->linkRequestStats->getId());
        $this->assertEquals($this->createdAt, $this->linkRequestStats->getCreatedAt());
        $this->assertEquals(self::IP, $this->linkRequestStats->getIp());
        $this->assertEquals(self::DEVICE, $this->linkRequestStats->getDevice());
        $this->assertEquals(self::REFERER, $this->linkRequestStats->getReferer());
        $this->assertEquals($this->shortLink, $this->linkRequestStats->getShortLink());
    }

    public function testInvalidDevice() {
        $this->expectException(\InvalidArgumentException::class);
        $this->linkRequestStats->setDevice('invalid');
    }
}