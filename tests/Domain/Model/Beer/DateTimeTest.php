<?php

namespace App\Tests\Domain\Model\Beer;

use App\Domain\Model\Beer\DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    public function testFromMonthAndYear(): void
    {
        $datetime = DateTime::fromString('01/1999');
        self::assertEquals('1999-01-01T00:00:00+00:00', $datetime->format(DATE_ATOM));
    }

    public function testFromYear(): void
    {
        $datetime = DateTime::fromString('1999');
        self::assertEquals('1999-01-01T00:00:00+00:00', $datetime->format(DATE_ATOM));
    }
}
