<?php

namespace App\Infrastructure\InMemory\Beer;

use App\Domain\Model\Beer\Beer;
use App\Domain\Model\Beer\BeerId;
use App\Domain\Model\Beer\BeerNotFoundException;
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

    public function findById(BeerId $id): Beer
    {
        $key = $id->getId();

        if (!isset($this->items[$key])) {
            throw BeerNotFoundException::formId($id);
        }

        return $this->items[$key][1];
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
