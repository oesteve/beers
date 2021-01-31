<?php

namespace App\Tests\Domain\Model\Beer;

use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerNotFoundException;
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

    public function testWithOneResult(): void
    {
        $provider = $this->getBeerProvider();
        $res = $provider->findByFood('Bravas');

        self::assertCount(1, $res);

        $expected = new Beer(
            BeerId::fromInt(2),
            'Mahou',
            'La cerveza que gusta en Madrid'
        );

        self::assertEquals($res[0], $expected);
    }

    public function testBeerNotFoundError(): void
    {
        $this->expectException(BeerNotFoundException::class);

        $provider = $this->getBeerProvider();
        $provider->findById(BeerId::fromInt(99));
    }

    public function tesGetBeer(): void
    {
        $this->expectException(BeerNotFoundException::class);
        $provider = $this->getBeerProvider();

        $beer = $provider->findById(BeerId::fromInt(1));

        self::assertInstanceOf(Beer::class, $beer);
    }
}
