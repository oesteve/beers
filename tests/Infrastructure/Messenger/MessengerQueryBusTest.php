<?php

namespace App\Tests\Infrastructure\Messenger;

use App\Application\Query\Query;
use App\Application\Query\QueryBus;
use App\Tests\Application\Handler\Query\TestQuery;
use App\Tests\Application\Model\TestDto;
use App\Tests\Infrastructure\BaseTestCase;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;

class MessengerQueryBusTest extends BaseTestCase
{
    public function testServiceInjection(): void
    {
        $bus = $this->get(QueryBus::class);
        self::assertInstanceOf(QueryBus::class, $bus);
    }

    public function testInvalidHandlerError(): void
    {
        /** @var QueryBus $bus */
        $bus = $this->get(QueryBus::class);

        // Demo disclaimer
        // This should be a custom exception instead using implementation exception
        $this->expectException(NoHandlerForMessageException::class);

        $bus->query(new InvalidQuery());
    }

    public function testReturnValue(): void
    {
        /** @var QueryBus $bus */
        $bus = $this->get(QueryBus::class);

        /** @var TestDto $res */
        $res = $bus->query(new TestQuery('foo'));

        self::assertInstanceOf(TestDto::class, $res);
        self::assertEquals('Hello foo', $res->getMessage());
    }
}

class InvalidQuery implements Query
{
}
