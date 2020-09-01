<?php

declare(strict_types=1);

namespace App;

use App\Shared\SessionMiddleware;
use Slim\App;

class Middlewares
{
    public function __invoke(App $app): void
    {
        $app->add(SessionMiddleware::class);
    }
}
