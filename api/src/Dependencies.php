<?php

declare(strict_types=1);

namespace App;

use DI\Container;
use DI\ContainerBuilder;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Dependencies
{
    /**
     * @param ContainerBuilder<Container> $containerBuilder
     * @throws \LogicException
     */
    public function __invoke(ContainerBuilder $containerBuilder): void
    {
        $containerBuilder->addDefinitions([
            LoggerInterface::class => static function (Settings $settings): Logger {
                $loggerSettings = $settings->logger;
                $logger = new Logger($loggerSettings['name']);

                $processor = new UidProcessor();
                $logger->pushProcessor($processor);

                $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
                $logger->pushHandler($handler);

                return $logger;
            },
            EntityManager::class => static function (Settings $settings) {
                $databaseSettings = $settings->database;

                $cache = $settings->debug ? new ArrayAdapter() : new FilesystemAdapter();
                $config = ORMSetup::createAttributeMetadataConfiguration(
                    paths: [__DIR__],
                    isDevMode: $settings->debug,
                    proxyDir: null,
                    cache: $cache,
                );
                $connection = DriverManager::getConnection($databaseSettings);

                return new EntityManager($connection, $config);
            },
        ]);
    }
}
