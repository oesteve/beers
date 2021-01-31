<?php

namespace App\Tests\UI\Controller;

use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerProvider;
use App\Infrastructure\InMemory\Beer\InMemoryBeerProvider;
use App\Tests\Infrastructure\BaseTestCase;

class BeersControllerTest extends BaseTestCase
{
    public function testInvalidParameter(): void
    {
        $this->client->request('GET', '/search?query=');

        self::assertResponseStatusCodeSame(500);
    }

    public function testSearchNoResult(): void
    {
        $this->client->request('GET', '/search?query=foo');

        self::assertResponseStatusCodeSame(200);

        $data = $this->getBodyData();

        self::assertEquals([], $data);
    }

    public function testSearchResults(): void
    {
        /** @var InMemoryBeerProvider $provider */
        $provider = $this->get(BeerProvider::class);
        $mahou = new Beer(
            BeerId::fromInt(1),
            'Mahou',
            'Un sabor 5 estrellas'
        );
        $provider->setBeer(['nachos'], $mahou);

        $this->client->request('GET', '/search?query=nachos');

        self::assertResponseStatusCodeSame(200);
        self::assertEquals([[
            'id' => 1,
            'name' => 'Mahou',
            'description' => 'Un sabor 5 estrellas',
        ]], $this->getBodyData());
    }

    public function testFind(): void
    {
        /** @var InMemoryBeerProvider $provider */
        $provider = $this->get(BeerProvider::class);
        $mahou = new Beer(
            BeerId::fromInt(1),
            'Mahou',
            'Un sabor 5 estrellas'
        );
        $provider->setBeer(['nachos'], $mahou);

        $this->client->request('GET', '/beer/1');

        self::assertResponseStatusCodeSame(200);
        self::assertEquals([
            'id' => 1,
            'name' => 'Mahou',
            'description' => 'Un sabor 5 estrellas',
        ], $this->getBodyData());
    }
}
