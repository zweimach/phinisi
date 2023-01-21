<?php

declare(strict_types=1);

namespace App\Authors;

use Psr\Http\Message\ResponseInterface as Response;

class CreateAuthorAction extends AuthorsAction
{
    protected function action(): Response
    {
        $request = $this->getFormData();
        $authorId = $this->authorsService->createAuthor($request['first_name'] ?? '', $request['last_name'] ?? '');

        return $this->respondWithData($authorId);
    }
}
