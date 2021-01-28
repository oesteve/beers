<?php

namespace App\Tests\Infrastructure\InMemory\Beer;

use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerProvider;
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
            "Homer Simpson's favorite beer"
        );

        $provider->setBeer(['foo'], $buff);

        $mahou = new Beer(
            BeerId::fromInt(2),
            'Mahou',
            'La cerveza que gusta en Madrid'
        );

        $provider->setBeer(['foo', 'Patatas bravas'], $mahou);

        return $provider;
    }
}
