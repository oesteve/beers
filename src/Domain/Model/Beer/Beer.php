<?php

namespace App\Domain\Model\Beer;

class Beer
{
    private BeerId $id;

    private string $name;

    private string $description;

    private Image $image;

    private string $slogan;

    private \DateTimeInterface $firstBrewed;

    public function __construct(BeerId $id, string $name, string $description, Image $image, string $slogan, \DateTimeInterface $firstBrewed)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->image = $image;
        $this->slogan = $slogan;
        $this->firstBrewed = $firstBrewed;
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
                $data['description'],
                new Image($data['image']),
                $data['slogan'],
                new \DateTimeImmutable($data['first_brewed']),
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

    public function getImage(): Image
    {
        return $this->image;
    }

    public function getSlogan(): string
    {
        return $this->slogan;
    }

    public function getFirstBrewed(): \DateTimeInterface
    {
        return $this->firstBrewed;
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
