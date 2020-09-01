<?php

declare(strict_types=1);

namespace App\Users;

use Psr\Http\Message\ResponseInterface as Response;

class ViewUserAction extends UsersAction
{
    protected function action(): Response
    {
        $userId = (int) $this->resolveArguments('id');
        $user = $this->usersService->findUserOfId($userId);

        return $this->respondWithData($user);
    }
}
