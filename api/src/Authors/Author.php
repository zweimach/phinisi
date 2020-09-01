<?php

declare(strict_types=1);

namespace App\Authors;

use JsonSerializable;

class Author implements JsonSerializable
{
    private int $id;

    private string $firstName;

    private string $lastName;

    /**
     * @param int|string $id
     */
    public function __construct($id, string $firstName, string $lastName)
    {
        $this->id = (int) $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
        ];
    }

    /**
     * @param array<string> $author
     */
    public static function of(array $author): self
    {
        $id = $author['id'];
        $firstName = $author['first_name'];
        $lastName = $author['last_name'];

        return new self($id, $firstName, $lastName);
    }
}
