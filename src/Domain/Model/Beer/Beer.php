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

    /**
     * @param array<string,string> $data
     *
     * @return Beer
     *
     * @throws \InvalidArgumentException
     */
    public static function fromData(array $data): self
    {
        try {
            return new self(
                BeerId::fromInt((int) $data['id']),
                $data['name'],
                $data['description']
            );
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
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

    public function getData(): array
    {
        return [
            'id' => $this->id->getId(),
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
