<?php

namespace App\Tests\Application\Handler\Query;

use App\Application\Handler\Query\GetBeer;
use App\Application\Model\BeerDetailDto;
use App\Application\Query\QueryBus;
use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerProvider;
use App\Domain\Model\Beer\DateTime;
use App\Domain\Model\Beer\Image;
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

        $mahou = new Beer(
            BeerId::fromInt(1),
            'Mahou',
            'Beer description',
            new Image('http://example.com/image.png'),
            'Un sabor 5 estrellas',
            DateTime::fromString('01/1988')
        );

        $beerProvider->setBeer(['nachos'], $mahou);

        $res = $queryBus->query(new GetBeer(1));

        $dto = new BeerDetailDto(
            1,
            'Mahou',
            'Beer description',
            'http://example.com/image.png',
            'Un sabor 5 estrellas',
            '1988-01-01T00:00:00+00:00'
        );

        self::assertEquals($res, $dto);
    }
}
