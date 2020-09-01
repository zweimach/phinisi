<?php

declare(strict_types=1);

use App\Settings;
use DI\ContainerBuilder;

require __DIR__ . '/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$settings = new Settings();
$settings($containerBuilder);

$container = $containerBuilder->build();
$config = $container->get('settings')['database'];

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'migration_log',
        'default_environment' => 'production',
        'production' => [
            'adapter' => $config['driver'],
            'host' => $config['host'],
            'name' => $config['database'],
            'user' => $config['username'],
            'pass' => $config['password'],
            'port' => $config['port'],
            'charset' => $config['charset'],
        ],
    ],
    'version_order' => 'creation'
];
