<?php

namespace App\Domain\Model\Beer;

class BeerId
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromInt(int $id): self
    {
        return new self($id);
    }

    public function getId(): int
    {
        return $this->id;
    }
}
