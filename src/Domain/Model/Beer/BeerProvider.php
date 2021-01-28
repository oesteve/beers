<?php

namespace App\Domain\Model\Beer;

interface BeerProvider
{
    /**
     * @return array<Beer>
     *
     * @throws BeerProviderException
     */
    public function findByFood(string $food): array;
}
