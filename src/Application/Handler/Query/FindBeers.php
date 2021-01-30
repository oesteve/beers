<?php

namespace App\Application\Handler\Query;

use App\Application\Query\Query;

class FindBeers implements Query
{
    private string $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}
