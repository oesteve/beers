<?php

namespace App\Tests\Infrastructure\Guzzle\Beer;

use App\Domain\Model\Beer\BeerProvider;
use App\Domain\Model\Beer\BeerProviderException;
use App\Infrastructure\Guzzle\Beer\GuzzleBeerProvider;
use App\Tests\Domain\Model\Beer\BeerProviderTest;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;

class GuzzleBeerProviderTest extends BeerProviderTest
{
    public function testCatchErrors(): void
    {
        $provider = $this->getBeerProvider();

        $this->expectException(BeerProviderException::class);
        $provider->findByFood('error');
    }

    public function getBeerProvider(): BeerProvider
    {
        $handler = function (RequestInterface $request) {
            $data = [];

            $path = $request->getUri()->getPath().$request->getUri()->getQuery();

            $match = preg_match('/food\=error/', $path);
            if ($match > 0) {
                return new FulfilledPromise(new Response(500));
            }

            $match = preg_match('/99$/', $path);
            if ($match > 0) {
                return new FulfilledPromise(new Response(404));
            }

            $match = preg_match('/food=foo/', $path);
            if ($match > 0) {
                $data = [
                    [
                        'id' => 1,
                        'name' => 'Buff',
                        'description' => "Homer Simpson's favorite beer",
                        'image' => 'https://example.com/image.png',
                        'slogan' => 'Duffman is here to refill your beer',
                        'first_brewed' => '1980-01-01T00:00:00.000000+0100',
                    ],
                    [
                        'id' => 4,
                        'name' => 'Beeeeer',
                        'description' => 'Unknow beer',
                        'image' => 'https://example.com/image.png',
                        'slogan' => 'Unknow slogan',
                        'first_brewed' => '1980-01-01T00:00:00.000000+0100',
                    ],
                ];
            }

            $match = preg_match('/food=Bravas/', $path);
            if ($match > 0) {
                $data = [
                    [
                        'id' => 2,
                        'name' => 'Mahou',
                        'description' => 'La cerveza que gusta en Madrid',
                        'image' => 'https://example.com/image.png',
                        'slogan' => 'Un sabor 5 estrellas',
                        'first_brewed' => '1980-01-01',
                    ],
                ];
            }

            $match = preg_match('/1$/', $path);
            if ($match > 0) {
                $data = [
                    'id' => 2,
                    'name' => 'Mahou',
                    'description' => 'La cerveza que gusta en Madrid',
                    'image' => 'https://example.com/image.png',
                    'slogan' => 'Un sabor 5 estrellas',
                    'first_brewed' => '1980-01-01',
                ];
            }

            return new FulfilledPromise(new Response(200, [], json_encode($data, JSON_THROW_ON_ERROR)));
        };

        $handlerStack = HandlerStack::create($handler);

        $client = new Client(['handler' => $handlerStack]);

        return new GuzzleBeerProvider($client);
    }
}
