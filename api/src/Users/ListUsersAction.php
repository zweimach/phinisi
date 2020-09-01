<?php

declare(strict_types=1);

namespace App\Users;

use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends UsersAction
{
    protected function action(): Response
    {
        $users = $this->usersService->findAll();

        return $this->respondWithData($users);
    }
}
