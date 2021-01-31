<?php

namespace App\Application\Handler\Query;

use App\Application\Query\QueryHandler;
use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerProvider;

class GetBeerHandler implements QueryHandler
{
    private BeerProvider $beerProvider;

    public function __construct(BeerProvider $beerProvider)
    {
        $this->beerProvider = $beerProvider;
    }

    public function __invoke(GetBeer $getBeer): Beer
    {
        $id = BeerId::fromInt($getBeer->getBeerId());

        return $this->beerProvider->findById($id);
    }
}
