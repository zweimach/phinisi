<?php

declare(strict_types=1);

namespace App;

use App\Shared\SessionMiddleware;
use Middlewares\TrailingSlash as TrailingSlashMiddleware;
use Slim\App;

class Middlewares
{
    public function __invoke(App $app): void
    {
        $app->add(new TrailingSlashMiddleware());
        $app->add(SessionMiddleware::class);
    }
}
