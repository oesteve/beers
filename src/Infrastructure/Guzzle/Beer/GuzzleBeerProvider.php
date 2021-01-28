<?php

namespace App\Infrastructure\Guzzle\Beer;

use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerProvider;
use App\Domain\Model\Beer\BeerProviderException;
use GuzzleHttp\Client;

class GuzzleBeerProvider implements BeerProvider
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function findByFood(string $food): array
    {
        try {
            $response = $this->client->request('GET', '/v2/beers?food='.$food);

            $data = json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);

            return array_map(fn ($data) => Beer::fromData($data), $data);
        } catch (\Throwable $exception) {
            /*
             * Demo disclaimer
             * Exceptions need more granularity
             */
            throw new BeerProviderException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
