<?php

namespace App\Tests\Infrastructure\InMemory\Beer;

use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerProvider;
use App\Domain\Model\Beer\Image;
use App\Infrastructure\InMemory\Beer\InMemoryBeerProvider;
use App\Tests\Domain\Model\Beer\BeerProviderTest;

class InMemoryBeerProviderTest extends BeerProviderTest
{
    public function getBeerProvider(): BeerProvider
    {
        $provider = new InMemoryBeerProvider();

        $buff = new Beer(
            BeerId::fromInt(1),
            'Buff',
            "Homer Simpson's favorite beer",
            new Image('https://example.com/image.png'),
            'Duffman is here to refill your beer',
            new \DateTimeImmutable('1980-01-01T00:00:00.000000+0100'),
        );

        $provider->setBeer(['foo'], $buff);

        $mahou = new Beer(
            BeerId::fromInt(2),
            'Mahou',
            'Beer description',
            new Image('http://example.com/image.png'),
            'Un sabor 5 estrellas',
            new \DateTime('1988-01-01')
        );

        $provider->setBeer(['foo', 'Patatas bravas'], $mahou);

        return $provider;
    }
}
