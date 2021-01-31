<?php

namespace App\Tests\Infrastructure;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    public function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
    }

    /**
     * @return object|null
     */
    protected function get(string $class)
    {
        // @phpstan-ignore-next-line
        return $this->client->getContainer()->get($class);
    }

    /**
     * @return mixed
     *
     * @throws \JsonException
     */
    protected function getBodyData()
    {
        $content = $this->client->getResponse()->getContent();

        if (!$content) {
            return null;
        }

        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }
}
