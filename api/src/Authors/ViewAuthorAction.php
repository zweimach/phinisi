<?php

declare(strict_types=1);

namespace App\Authors;

use Psr\Http\Message\ResponseInterface as Response;

class ViewAuthorAction extends AuthorsAction
{
    protected function action(): Response
    {
        $authorId = (int) $this->resolveArguments('id');
        $author = $this->authorsService->findAuthorOfId($authorId);

        return $this->respondWithData($author);
    }
}
