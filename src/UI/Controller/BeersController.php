<?php

namespace App\UI\Controller;

use App\Application\Handler\Query\FindBeers;
use App\Application\Handler\Query\GetBeer;
use App\Application\Query\QueryBus;
use App\Domain\Model\Beer\Beer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class BeersController
{
    public function search(Request $request, QueryBus $queryBus): Response
    {
        $query = $request->query->get('query');
        if (!$query) {
            throw new InvalidParameterException('Invalid query param value');
        }

        /** @var array<Beer> $res */
        $res = $queryBus->query(new FindBeers($query));
        $data = array_map(fn (Beer $beer) => $beer->getData(), $res);

        return new JsonResponse($data);
    }

    public function detail(int $id, QueryBus $queryBus): Response
    {
        /** @var Beer $beer */
        $beer = $queryBus->query(new GetBeer($id));

        return new JsonResponse($beer->getData());
    }
}
