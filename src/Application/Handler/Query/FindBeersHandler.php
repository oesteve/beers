<?php

namespace App\Application\Handler\Query;

use App\Application\Query\QueryHandler;
use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerProvider;
use App\Domain\Model\Beer\BeerProviderException;

class FindBeersHandler implements QueryHandler
{
    private BeerProvider $beerProvider;

    public function __construct(BeerProvider $beerProvider)
    {
        $this->beerProvider = $beerProvider;
    }

    /**
     * @return array<Beer>
     *
     * @throws BeerProviderException
     */
    public function __invoke(FindBeers $findBeers): array
    {
        return $this->beerProvider->findByFood($findBeers->getQuery());
    }
}
