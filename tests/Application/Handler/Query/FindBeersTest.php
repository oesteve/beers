<?php

namespace App\Tests\Application\Handlers\Query;

use App\Application\Handlers\Query\FindBeers;
use App\Application\Handlers\Query\FindBeersHandler;
use App\Application\Query\QueryBus;
use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerProvider;
use App\Infrastructure\InMemory\Beer\InMemoryBeerProvider;
use App\Tests\Infrastructure\BaseTestCase;

class FindBeersTest extends BaseTestCase
{
    public function testEmptyResult(): void
    {
        $provider = new InMemoryBeerProvider();
        $handler = new FindBeersHandler($provider);

        $res = $handler(new FindBeers('bar'));

        self::assertCount(0, $res);
    }

    public function testFunctionalEmptyResult(): void
    {
        $queryBus = $this->get(QueryBus::class);

        $res = $queryBus->query(new FindBeers('foo'));

        self::assertCount(0, $res);
    }

    public function testFindResults(): void
    {
        /** @var InMemoryBeerProvider $provider */
        $provider = $this->get(BeerProvider::class);
        $queryBus = $this->get(QueryBus::class);

        $provider->setBeer(['nachos'], new Beer(BeerId::fromInt(1), 'Mahou', 'Un sabor 5 estrellas'));

        $res = $queryBus->query(new FindBeers('nachos'));

        self::assertCount(1, $res);
        self::assertInstanceOf(Beer::class, $res[0]);
    }
}
