<?php

declare(strict_types=1);

namespace App\Books;

use Psr\Http\Message\ResponseInterface as Response;

class ListBooksAction extends BooksAction
{
    protected function action(): Response
    {
        $books = $this->booksService->findAll();

        return $this->respondWithData($books);
    }
}
