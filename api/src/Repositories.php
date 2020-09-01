<?php

declare(strict_types=1);

namespace App;

use App\Authors\AuthorsRepository;
use App\Authors\AuthorsService;
use App\Books\BooksRepository;
use App\Books\BooksService;
use App\Users\UsersRepository;
use App\Users\UsersService;
use DI\ContainerBuilder;

use function DI\autowire;

class Repositories
{
    public function __invoke(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addDefinitions([
            AuthorsService::class => autowire(AuthorsRepository::class),
            BooksService::class => autowire(BooksRepository::class),
            UsersService::class => autowire(UsersRepository::class),
        ]);
    }
}
