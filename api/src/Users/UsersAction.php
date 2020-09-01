<?php

declare(strict_types=1);

namespace App\Users;

use App\Shared\Action;
use Psr\Log\LoggerInterface;

abstract class UsersAction extends Action
{
    protected UsersService $usersService;

    public function __construct(LoggerInterface $logger, UsersService $usersService)
    {
        parent::__construct($logger);
        $this->usersService = $usersService;
    }
}
