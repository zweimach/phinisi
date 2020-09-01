<?php

declare(strict_types=1);

namespace App\Authors;

use Psr\Http\Message\ResponseInterface as Response;

class ListAuthorsAction extends AuthorsAction
{
    protected function action(): Response
    {
        $authors = $this->authorsService->findAll();

        return $this->respondWithData($authors);
    }
}
