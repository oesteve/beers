<?php

namespace App\Tests\Application\Handler\Query;

use App\Application\DataTransformer\ResultDataTransformer;
use App\Application\Handler\Query\FindBeers;
use App\Application\Handler\Query\FindBeersHandler;
use App\Application\Model\BeerResultDto;
use App\Application\Query\QueryBus;
use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerProvider;
use App\Domain\Model\Beer\Image;
use App\Infrastructure\InMemory\Beer\InMemoryBeerProvider;
use App\Tests\Infrastructure\BaseTestCase;

class FindBeersTest extends BaseTestCase
{
    public function testEmptyResult(): void
    {
        $provider = new InMemoryBeerProvider();
        $transformer = new ResultDataTransformer();

        $handler = new FindBeersHandler($provider, $transformer);

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

        $mahou = new Beer(
            BeerId::fromInt(1),
            'Mahou',
            'Beer description',
            new Image('http://example.com/image.png'),
            'Un sabor 5 estrellas',
            new \DateTime('1988-01-01')
        );

        $provider->setBeer(['nachos'], $mahou);

        /** @var array $res */
        $res = $queryBus->query(new FindBeers('nachos'));

        self::assertCount(1, $res);
        self::assertInstanceOf(BeerResultDto::class, $res[0]);
    }
}
