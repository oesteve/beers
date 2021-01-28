<?php

namespace App\Domain\Model\Beer;

class Beer
{
    private BeerId $id;

    private string $name;

    private string $description;

    public function __construct(BeerId $id, string $name, string $description)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
    }

    public function getId(): BeerId
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
