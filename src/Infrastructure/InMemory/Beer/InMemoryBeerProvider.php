<?php

namespace App\Infrastructure\InMemory\Beer;

use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerProvider;

class InMemoryBeerProvider implements BeerProvider
{
    /** @var array<int,array> */
    private $items = [];

    public function findByFood(string $food): array
    {
        $res = [];

        foreach ($this->items as $item) {
            /**
             * @var array<string> $foods
             * @var Beer          $beer
             */
            [ $foods, $beer ] = $item;
            if ($this->matchFood($foods, $food)) {
                $res[] = $beer;
            }
        }

        return $res;
    }

    /**
     * @param array<string> $foods
     */
    public function setBeer(array $foods, Beer $beer): void
    {
        $this->items[$beer->getId()->getId()] = [$foods, $beer];
    }

    private function matchFood(array $foods, string $match): bool
    {
        $res = [];

        foreach ($foods as $item) {
            $preg = preg_match("/$match/i", $item, $res);
            if (0 !== $preg) {
                return true;
            }
        }

        return false;
    }
}
