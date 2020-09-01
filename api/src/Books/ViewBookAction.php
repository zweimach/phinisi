<?php

declare(strict_types=1);

namespace App\Books;

use Psr\Http\Message\ResponseInterface as Response;

class ViewBookAction extends BooksAction
{
    protected function action(): Response
    {
        $bookId = (int) $this->resolveArguments('id');
        $book = $this->booksService->findBookOfId($bookId);

        return $this->respondWithData($book);
    }
}
