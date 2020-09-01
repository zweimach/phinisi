<?php

declare(strict_types=1);

namespace Tests;

use App\Users\UsersService;
use DI\ContainerBuilder;
use Tests\Users\InMemoryUserRepository;

use function DI\autowire;

class Repositories
{
    public function __invoke(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addDefinitions([
            UsersService::class => autowire(InMemoryUserRepository::class),
        ]);
    }
}
