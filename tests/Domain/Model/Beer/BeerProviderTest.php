<?php

namespace App\Tests\Domain\Model\Beer;

use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerProvider;
use PHPUnit\Framework\TestCase;

abstract class BeerProviderTest extends TestCase
{
    abstract public function getBeerProvider(): BeerProvider;

    public function testNoResults(): void
    {
        $provider = $this->getBeerProvider();
        $res = $provider->findByFood('bar');

        self::assertCount(0, $res);
    }

    public function testWithResults(): void
    {
        $provider = $this->getBeerProvider();
        $res = $provider->findByFood('foo');

        self::assertCount(2, $res);

        $expected = new Beer(
            BeerId::fromInt(1),
            'Buff',
            "Homer Simpson's favorite beer"
        );
        self::assertEquals($res[0], $expected);
    }
}