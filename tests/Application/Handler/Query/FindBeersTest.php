<?php

namespace App\Tests\Application\Handler\Query;

use App\Application\Handler\Query\FindBeers;
use App\Application\Handler\Query\FindBeersHandler;
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

        /** @var array $res */
        $res = $handler(new FindBeers('bar'));

        self::assertCount(0, $res);
    }

    public function testFunctionalEmptyResult(): void
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);

        /** @var array $res */
        $res = $queryBus->query(new FindBeers('foo'));

        self::assertCount(0, $res);
    }

    public function testFindResults(): void
    {
        /** @var InMemoryBeerProvider $provider */
        $provider = $this->get(BeerProvider::class);
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);

        $provider->setBeer(['nachos'], new Beer(BeerId::fromInt(1), 'Mahou', 'Un sabor 5 estrellas'));

        /** @var array $res */
        $res = $queryBus->query(new FindBeers('nachos'));

        self::assertCount(1, $res);
        self::assertInstanceOf(Beer::class, $res[0]);
    }
}
