<?php

declare(strict_types=1);

namespace Tests;

use App\Users\UsersService;
use DI\Container;
use DI\ContainerBuilder;
use Tests\Users\InMemoryUserRepository;

use function DI\autowire;

class Repositories
{
    /**
     * @param ContainerBuilder<Container> $containerBuilder
     * @throws \LogicException
     */
    public function __invoke(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addDefinitions([
            UsersService::class => autowire(InMemoryUserRepository::class),
        ]);
    }
}
