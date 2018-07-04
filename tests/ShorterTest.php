<?php

namespace App\Tests;

use App\Services\ShortLink\Shorter;
use App\Services\ShortLink\WrongIdShorterException;
use App\Services\ShortLink\WrongUrlShorterException;
use PHPUnit\Framework\TestCase;

class ShorterTest extends TestCase
{
    public function testShorter()
    {
        $shorter = new Shorter();

        $ids = [0, 1, 123, 123456, 987654321];
        $urls = [];

        $idsLength = count($ids);

        for ($i = 0 ; $i < $idsLength ; $i++) {
            $urls[$i] = $shorter->getShorterUrl($ids[$i]);
        }

        for ($i = 0 ; $i < $idsLength ; $i++) {
            $this->assertequals($ids[$i], $shorter->getShorterId($urls[$i]));
        }
    }

    public function testShorterWrongIds()
    {
        $shorter = new Shorter();

        $this->expectException(WrongIdShorterException::class);
        $shorter->getShorterUrl(-1);
    }

    public function testShorterWrongUrls()
    {
        $shorter = new Shorter();

        $this->expectException(WrongUrlShorterException::class);
        $shorter->getShorterId('');

        $this->expectException(WrongUrlShorterException::class);
        $shorter->getShorterId('-1');

        $this->expectException(WrongUrlShorterException::class);
        $shorter->getShorterId('abc.abc');

        $this->expectException(WrongUrlShorterException::class);
        $shorter->getShorterId('.abc');

        $this->expectException(WrongUrlShorterException::class);
        $shorter->getShorterId('abc.');
    }
}
