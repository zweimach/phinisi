<?php

declare(strict_types=1);

namespace App\Books;

use App\Authors\Author;
use DateTimeImmutable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use JsonSerializable;

#[Entity, Table(name: 'books')]
class Book implements JsonSerializable
{
    #[Id, Column(type: 'integer'), GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[Column(type: 'string', nullable: false)]
    private string $title;

    #[Column(type: 'text', nullable: false)]
    private string $description;

    #[Column(name: 'publication_date', type: 'date_immutable', nullable: false)]
    private DateTimeImmutable $publicationDate;

    #[ManyToOne(targetEntity: Author::class)]
    #[JoinColumn(name: 'author_id', referencedColumnName: 'id')]
    private ?Author $author = null;

    public function __construct(
        int $id,
        string $title,
        string $description,
        DateTimeImmutable $publicationDate,
        ?Author $author,
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->publicationDate = $publicationDate;
        $this->author = $author;
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

    public function publicationDate(): DateTimeImmutable
    {
        return $this->publicationDate;
    }

    public function author(): ?Author
    {
        return $this->author;
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
            'authorId' => $this->author?->id(),
        ];
    }
}
