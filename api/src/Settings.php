<?php

declare(strict_types=1);

namespace App;

use Monolog\Level;

class Settings
{
    public readonly bool $debug;

    /**
     * @var array{name: string, path: string, level: Level}
     */
    public readonly array $logger;

    /**
     * @var array{driver: 'pgsql', host: string, port: int, dbname: string, user: string, password: string, charset: string}
     */
    public readonly array $database;

    /**
     * @var array{secret: string, origins: string, url: string}
     */
    public readonly array $security;

    public function __construct()
    {
        $debug = isset($_ENV['APP_DEBUG']) && $_ENV['APP_DEBUG'] === true;
        $this->debug = $debug;
        $this->logger = [
            'name' => $_ENV['APP_NAME'],
            'path' => isset($_ENV['docker']) || $_ENV['APP_STDOUT'] ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => $debug ? Level::Debug : Level::Info,
        ];
        $this->database = [
            'driver' => 'pgsql',
            'host' => $_ENV['DB_HOST'],
            'port' => intval($_ENV['DB_PORT']),
            'dbname' => $_ENV['DB_DATABASE'],
            'user' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => 'utf-8',
        ];
        $this->security = [
            'secret' => $_ENV['SECRET'],
            'origins' => $_ENV['ALLOWED_ORIGINS'],
            'url' => $_ENV['APP_URL'],
        ];
    }
}
