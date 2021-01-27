<?php

namespace App\Tests\Application\Handler\Query;

use App\Application\Query\Query;

class TestQuery implements Query
{
    private string $bar;

    public function __construct(string $bar)
    {
        $this->bar = $bar;
    }

    public function getBar(): string
    {
        return $this->bar;
    }
}
