<?php

namespace App\Tests;

use App\Tests\Infrastructure\BaseTestCase;

class BasicTest extends BaseTestCase
{
    public function testTrueShouldBeTrue(): void
    {
        self::assertTrue(true);
    }

    public function testClientRunInTestEnv(): void
    {
        // @phpstan-ignore-next-line
        $envName = $this->client->getKernel()->getEnvironment();

        self::assertEquals($envName, 'test');
    }
}
