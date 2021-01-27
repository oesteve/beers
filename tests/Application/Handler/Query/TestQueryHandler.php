<?php

namespace App\Tests\Application\Handler\Query;

use App\Application\Query\QueryHandler;
use App\Tests\Application\Model\TestDto;

class TestQueryHandler implements QueryHandler
{
    public function __invoke(TestQuery $query): TestDto
    {
        return new TestDto(sprintf('Hello %s', $query->getBar()));
    }
}
