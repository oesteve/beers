<?php

namespace App\Tests;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BasicTest extends WebTestCase
{
    public function testTrueShouldBeTrue(): void
    {
        $this->assertTrue(true);
    }

    public function testClientRunInTestEnv(): void
    {
        $client = static::createClient();

        $envName = $client->getKernel()->getEnvironment();

        $this->assertEquals($envName, 'test');
    }
}
