<?php

namespace App\Application\Handler\Query;

use App\Application\DataTransformer\ResultDataTransformer;
use App\Application\Model\BeerResultDto;
use App\Application\Query\QueryHandler;
use App\Domain\Model\Beer\BeerProvider;
use App\Domain\Model\Beer\BeerProviderException;

class FindBeersHandler implements QueryHandler
{
    private BeerProvider $beerProvider;
    private ResultDataTransformer $transformer;

    public function __construct(BeerProvider $beerProvider, ResultDataTransformer $transformer)
    {
        $this->beerProvider = $beerProvider;
        $this->transformer = $transformer;
    }

    /**
     * @return array<BeerResultDto>
     *
     * @throws BeerProviderException
     */
    public function __invoke(FindBeers $findBeers): array
    {
        $beers = $this->beerProvider->findByFood($findBeers->getQuery());

        return $this->transformer->transformResult($beers);
    }
}
