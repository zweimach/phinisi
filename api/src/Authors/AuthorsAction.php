<?php

declare(strict_types=1);

namespace App\Authors;

use App\Shared\Action;
use Psr\Log\LoggerInterface;

abstract class AuthorsAction extends Action
{
    protected AuthorsService $authorsService;

    public function __construct(LoggerInterface $logger, AuthorsService $authorsService)
    {
        parent::__construct($logger);
        $this->authorsService = $authorsService;
    }
}
