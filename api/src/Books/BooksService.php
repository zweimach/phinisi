<?php

declare(strict_types=1);

namespace App\Books;

interface BooksService
{
    /**
     * @return array<Book>
     */
    public function findAll(): array;

    /**
     * @throws BookNotFoundException
     */
    public function findBookOfId(int $id): Book;
}
