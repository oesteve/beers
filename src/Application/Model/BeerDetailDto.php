<?php

namespace App\Application\Model;

class BeerDetailDto
{
    private int $id;

    private string $name;

    private string $description;

    private string $image;

    private string $slogan;

    private string $firstBrewed;

    public function __construct(int $id, string $name, string $description, string $image, string $slogan, string $firstBrewed)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->slogan = $slogan;
        $this->firstBrewed = $firstBrewed;
    }

    public function getData(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'image' => $this->image,
            'slogan' => $this->slogan,
            'firstBrewed' => $this->firstBrewed,
        ];
    }
}
