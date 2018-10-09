<?php

namespace App\Tests\Services;

use App\Services\ShortLink\Shorter;
use App\Services\ShortLink\WrongIdShorterException;
use App\Services\ShortLink\WrongUrlShorterException;
use PHPUnit\Framework\TestCase;

class ShorterTest extends TestCase
{
    private $ids;
    private $urls;

    private $invalidIds;
    private $invalidUrls;

    /** @var Shorter */
    private $shorter;

    public function setUp() {
        $this->shorter = new Shorter();

        $this->ids = [0, 1, 123, 123456, 987654321];
        $this->urls = ['a', 'b', 'b9', 'Gho', 'be0gaz'];

        $this->invalidIds = [-1, '', 'abc'];
        $this->invalidUrls = ['', '-1', 'abc.abc', '.abc', 'abc.'];
    }

    public function testUrlGeneration()
    {
        $idsLength = count($this->ids);

        for ($i = 0 ; $i < $idsLength ; $i++) {
            $this->assertEquals($this->urls[$i], $this->shorter->getShorterUrl($this->ids[$i]));
        }
    }

    public function testIdGeneration() {
        $idsLength = count($this->ids);

        for ($i = 0 ; $i < $idsLength ; $i++) {
            $this->assertequals($this->ids[$i], $this->shorter->getShorterId($this->urls[$i]));
        }
    }

    public function testInvalidIds()
    {
        foreach ($this->invalidIds as $invalidId) {
            $this->assertInvalidId($invalidId);
        }
    }

    private function assertInvalidId($id) {
        $this->expectException(WrongIdShorterException::class);
        $this->shorter->getShorterUrl($id);
    }

    public function testInvalidUrls()
    {
        foreach ($this->invalidUrls as $invalidUrl) {
            $this->assertInvalidUrl($invalidUrl);
        }
    }

    private function assertInvalidUrl($url) {
        $this->expectException(WrongUrlShorterException::class);
        $this->shorter->getShorterId($url);
    }
}
