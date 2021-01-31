<?php

namespace App\Tests\Application\Handler\Query;

use App\Application\Handler\Query\GetBeer;
use App\Application\Query\QueryBus;
use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerProvider;
use App\Infrastructure\InMemory\Beer\InMemoryBeerProvider;
use App\Tests\Infrastructure\BaseTestCase;
use Symfony\Component\Messenger\Exception\HandlerFailedException;

class GetBeerTest extends BaseTestCase
{
    public function testNotFoundBeerError(): void
    {
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);

        $this->expectException(HandlerFailedException::class);
        $queryBus->query(new GetBeer(1));
    }

    public function testGetBeer(): void
    {
        /** @var InMemoryBeerProvider $beerProvider */
        $beerProvider = $this->get(BeerProvider::class);
        /** @var QueryBus $queryBus */
        $queryBus = $this->get(QueryBus::class);

        $mahou = new Beer(BeerId::fromInt(1), 'Mahou', 'Un sabor 5 estrellas');
        $beerProvider->setBeer(['nachos'], $mahou);

        $res = $queryBus->query(new GetBeer(1));

        self::assertEquals($res, $mahou);
    }
}
