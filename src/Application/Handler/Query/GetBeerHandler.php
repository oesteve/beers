<?php

namespace App\Application\Handler\Query;

use App\Application\DataTransformer\DetailDataTransformer;
use App\Application\Model\BeerDetailDto;
use App\Application\Query\QueryHandler;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerProvider;

class GetBeerHandler implements QueryHandler
{
    private BeerProvider $beerProvider;
    private DetailDataTransformer $transformer;

    public function __construct(BeerProvider $beerProvider, DetailDataTransformer $transformer)
    {
        $this->beerProvider = $beerProvider;
        $this->transformer = $transformer;
    }

    public function __invoke(GetBeer $getBeer): BeerDetailDto
    {
        $id = BeerId::fromInt($getBeer->getBeerId());
        $beer = $this->beerProvider->findById($id);

        return $this->transformer->transform($beer);
    }
}
