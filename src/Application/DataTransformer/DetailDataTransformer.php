<?php

namespace App\Application\DataTransformer;

use App\Application\Model\BeerDetailDto;
use App\Domain\Model\Beer\Beer;

class DetailDataTransformer
{
    public function transform(Beer $beer): BeerDetailDto
    {
        return new BeerDetailDto(
            $beer->getId()->getId(),
            $beer->getName(),
            $beer->getDescription(),
            $beer->getImage()->getUrl(),
            $beer->getSlogan(),
            $beer->getFirstBrewed()->format(DATE_ATOM)
        );
    }
}
