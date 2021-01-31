<?php

namespace App\UI\Controller;

use App\Application\Handler\Query\FindBeers;
use App\Application\Handler\Query\GetBeer;
use App\Application\Model\BeerResultDto;
use App\Application\Query\QueryBus;
use App\Domain\Model\Beer\Beer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BeersController
{
    public function search(Request $request, QueryBus $queryBus): Response
    {
        $query = $request->query->get('query');
        if (!$query) {
            return new JsonResponse(['message' => 'Invalid query param value'], 400);
        }

        /** @var array<BeerResultDto> $res */
        $res = $queryBus->query(new FindBeers($query));
        $data = array_map(fn (BeerResultDto $beer) => $beer->getData(), $res);

        return new JsonResponse($data);
    }

    public function detail(int $id, QueryBus $queryBus): Response
    {
        /** @var Beer $beer */
        $beer = $queryBus->query(new GetBeer($id));

        return new JsonResponse($beer->getData());
    }
}
