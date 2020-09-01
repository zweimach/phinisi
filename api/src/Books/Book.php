<?php

declare(strict_types=1);

namespace App\Books;

use JsonSerializable;

class Book implements JsonSerializable
{
    private int $id;

    private string $title;

    private string $description;

    private string $publicationDate;

    private string $authorId;

    /**
     * @param int|string $id
     */
    public function __construct(
        $id,
        string $title,
        string $description,
        string $publicationDate,
        string $authorId
    ) {
        $this->id = (int) $id;
        $this->title = $title;
        $this->description = $description;
        $this->publicationDate = $publicationDate;
        $this->authorId = $authorId;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function publicationDate(): string
    {
        return $this->publicationDate;
    }

    public function authorId(): string
    {
        return $this->authorId;
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'publicationDate' => $this->publicationDate,
            'authorId' => $this->authorId,
        ];
    }

    /**
     * @param array<string> $book
     */
    public static function of(array $book): self
    {
        $id = $book['id'];
        $title = $book['title'];
        $description = $book['description'];
        $publicationDate = $book['publication_date'];
        $authorId = $book['author_id'];

        return new self($id, $title, $description, $publicationDate, $authorId);
    }
}
