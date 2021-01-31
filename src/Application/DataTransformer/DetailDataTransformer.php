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
            null !== $beer->getImage() ? $beer->getImage()->getUrl() : null,
            $beer->getSlogan(),
            $beer->getFirstBrewed()->format(DATE_ATOM)
        );
    }
}
