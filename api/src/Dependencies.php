<?php

declare(strict_types=1);

namespace App;

use DI\ContainerBuilder;
use Medoo\Medoo;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class Dependencies
{
    public function __invoke(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addDefinitions([
            LoggerInterface::class => static function (ContainerInterface $container): Logger {
                $settings = $container->get('settings');

                $loggerSettings = $settings['logger'];
                $logger = new Logger($loggerSettings['name']);

                $processor = new UidProcessor();
                $logger->pushProcessor($processor);

                $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
                $logger->pushHandler($handler);

                return $logger;
            },
            Medoo::class => static function (ContainerInterface $container): Medoo {
                $config = $container->get('settings')['database'];

                return new Medoo([
                    'type' => $config['driver'],
                    'database' => $config['database'],
                    'host' => $config['host'],
                    'port' => $config['port'],
                    'username' => $config['username'],
                    'password' => $config['password'],
                    'charset' => $config['charset'],
                ]);
            },
        ]);
    }
}
