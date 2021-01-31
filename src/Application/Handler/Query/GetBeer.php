<?php

namespace App\Application\Handler\Query;

use App\Application\Query\Query;

class GetBeer implements Query
{
    private int $beerId;

    public function __construct(int $beerId)
    {
        $this->beerId = $beerId;
    }

    public function getBeerId(): int
    {
        return $this->beerId;
    }
}
