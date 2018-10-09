<?php

namespace App\Tests\Services;

use App\Entity\ShortLink;
use App\Services\ShortLink\Shorter;
use App\Services\ShortLink\ShortUrlGenerator;
use PHPUnit\Framework\TestCase;

class ShortUrlGeneratorTest extends TestCase {

    const FRONT_URL = 'http://shor.tr/';
    const SHORTER_TEST_ID = '1';
    const SHORTER_TEST_URL = 'b';

    /** @var ShortUrlGenerator */
    private $urlGenerator;

    public function setUp() {
        $shorterMock = $this->createShorterMock();
        $this->urlGenerator = new ShortUrlGenerator(self::FRONT_URL, $shorterMock);
    }

    public function testUrlGenerator() {
        $shortLink = new ShortLink(self::SHORTER_TEST_ID, self::SHORTER_TEST_URL);
        $this->assertEquals(self::FRONT_URL.self::SHORTER_TEST_URL, $this->urlGenerator->shortUrl($shortLink));
    }

    private function createShorterMock() {
        $mobileDetectorMock = $this->getMockBuilder(Shorter::class)
            ->setMethods(['getShorterUrl'])
            ->getMock();

        $mobileDetectorMock
            ->expects($this->once())
            ->method('getShorterUrl')
            ->willReturn(self::SHORTER_TEST_URL);

        return $mobileDetectorMock;
    }
}