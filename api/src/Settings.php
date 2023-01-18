<?php

declare(strict_types=1);

namespace App;

use DI\ContainerBuilder;
use Monolog\Level;

class Settings
{
    public function __invoke(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addDefinitions([
            'settings' => [
                'displayErrorDetails' => isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] !== 'true',
                'logger' => [
                    'name' => $_ENV['APP_NAME'],
                    'path' => isset($_ENV['docker']) || $_ENV['APP_STDOUT'] ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Level::Debug,
                ],
                'database' => [
                    'driver' => $_ENV['DB_CONNECTION'],
                    'host' => $_ENV['DB_HOST'],
                    'database' => $_ENV['DB_DATABASE'],
                    'username' => $_ENV['DB_USERNAME'],
                    'password' => $_ENV['DB_PASSWORD'],
                    'port' => $_ENV['DB_PORT'],
                    'charset' => 'utf8',
                ],
                'security' => [
                    'secret' => $_ENV['SECRET'],
                    'origins' => $_ENV['ALLOWED_ORIGINS'],
                ],
            ],
        ]);
    }
}
