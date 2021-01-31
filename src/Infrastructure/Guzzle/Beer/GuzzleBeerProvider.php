<?php

namespace App\Infrastructure\Guzzle\Beer;

use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerNotFoundException;
use App\Domain\Model\Beer\BeerProvider;
use App\Domain\Model\Beer\BeerProviderException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class GuzzleBeerProvider implements BeerProvider
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    public function findByFood(string $food): array
    {
        $request = '/v2/beers?food='.$food;

        try {
            $data = $this->get($request);

            return array_map(fn ($data) => Beer::fromData($data), $data);
        } catch (\Exception $e) {
            throw new BeerProviderException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function findById(BeerId $id): Beer
    {
        $request = '/v2/beers/'.$id->getId();

        try {
            $data = $this->get($request);

            return Beer::fromData($data[0]);
        } catch (\Exception $e) {
            if ($e instanceof ClientException && 404 === $e->getResponse()->getStatusCode()) {
                throw BeerNotFoundException::formId($id);
            }
            throw new BeerProviderException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @throws BeerProviderException
     */
    private function get(string $request): array
    {
        $response = $this->client->request('GET', $request);

        return json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }
}
