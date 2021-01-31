<?php

namespace App\Domain\Model\Beer;

use DateTimeZone;

class DateTime extends \DateTimeImmutable
{
    public static function fromString(string $str): \DateTimeInterface
    {
        $pattern = "/(\d{2})?(\/)?(?:(\d{4}))/";

        if (!preg_match($pattern, $str, $match)) {
            throw new \InvalidArgumentException('Invalid date format');
        }

        $year = $match[3];
        $month = '' !== $match[1] ? $match[1] : '01';
        $day = '01';

        $str = sprintf('%s-%s-%s 00:00:00', $year, $month, $day);
        $dateTime = static::createFromFormat('Y-m-d H:i:s', $str, new DateTimeZone('UTC'));

        if (false === $dateTime) {
            throw new \InvalidArgumentException('Invalid date format');
        }

        return $dateTime;
    }
}
