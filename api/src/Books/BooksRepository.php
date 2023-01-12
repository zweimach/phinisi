<?php

declare(strict_types=1);

namespace App\Books;

use Medoo\Medoo;

class BooksRepository implements BooksService
{
    private const COLUMN = ['id', 'title', 'description', 'publication_date', 'author_id'];

    private Medoo $database;

    public function __construct(Medoo $database)
    {
        $this->database = $database;
    }

    /**
     * @return array<Book>
     */
    public function findAll(): array
    {
        $books = $this->database->select('books', self::COLUMN);
        if ($books === null) {
            $books = [];
        }

        return array_map(fn ($book) => Book::of($book), $books);
    }

    /**
     * @throws BookNotFoundException
     */
    public function findBookOfId(int $id): Book
    {
        $book = $this->database->get('books', self::COLUMN, [
            'id' => $id,
        ]);
        if (! isset($book)) {
            throw new BookNotFoundException();
        }

        return Book::of($book);
    }
}
