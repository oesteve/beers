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
        self::assertEquals($res[0]->getId(), BeerId::fromInt(1));
    }

    public function testWithOneResult(): void
    {
        $provider = $this->getBeerProvider();
        $res = $provider->findByFood('Bravas');

        self::assertCount(1, $res);
        self::assertEquals($res[0]->getId(), BeerId::fromInt(2));
    }

    public function testBeerNotFoundError(): void
    {
        $this->expectException(BeerNotFoundException::class);

        $provider = $this->getBeerProvider();
        $provider->findById(BeerId::fromInt(99));
    }

    public function testGetBeer(): void
    {
        $provider = $this->getBeerProvider();

        $beer = $provider->findById(BeerId::fromInt(1));

        self::assertInstanceOf(Beer::class, $beer);
    }
}
