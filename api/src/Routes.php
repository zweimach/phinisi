<?php

declare(strict_types=1);

namespace App;

use App\Authors\ListAuthorsAction;
use App\Authors\ViewAuthorAction;
use App\Books\ListBooksAction;
use App\Books\ViewBookAction;
use App\Users\ListUsersAction;
use App\Users\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

class Routes
{
    public function __invoke(App $app): void
    {
        $app->options('/{routes:.*}', function (Request $request, Response $response): Response {
            return $response;
        });

        $app->group('/users', function (Group $group): void {
            $group->get('', ListUsersAction::class);
            $group->get('/{id}', ViewUserAction::class);
        });

        $app->group('/books', function (Group $group): void {
            $group->get('', ListBooksAction::class);
            $group->get('/{id}', ViewBookAction::class);
        });

        $app->group('/authors', function (Group $group): void {
            $group->get('', ListAuthorsAction::class);
            $group->get('/{id}', ViewAuthorAction::class);
        });
    }
}
