<?php

namespace App\Application\DataTransformer;

use App\Application\Model\BeerResultDto;
use App\Domain\Model\Beer\Beer;

class ResultDataTransformer
{
    /**
     * @param array<Beer> $beers
     *
     * @return array<BeerResultDto>
     */
    public function transformResult(array $beers): array
    {
        return array_map(fn (Beer $beer) => $this->transform($beer), $beers);
    }

    private function transform(Beer $beer): BeerResultDto
    {
        return new BeerResultDto(
            $beer->getId()->getId(),
            $beer->getName(),
            $beer->getDescription()
        );
    }
}
