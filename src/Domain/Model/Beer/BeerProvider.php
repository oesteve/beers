<?php

namespace App\Domain\Model\Beer;

interface BeerProvider
{
    /**
     * @return array<Beer>
     */
    public function findByFood(string $food): array;
}
