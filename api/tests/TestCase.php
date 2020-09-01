<?php

declare(strict_types=1);

namespace Tests;

use App\Dependencies;
use App\Middlewares;
use App\Routes;
use App\Settings;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Exception;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Psr7\Factory\StreamFactory;
use Slim\Psr7\Headers;
use Slim\Psr7\Request as SlimRequest;
use Slim\Psr7\Uri;

class TestCase extends PHPUnitTestCase
{
    /**
     * @throws Exception
     */
    protected function getAppInstance(): App
    {
        if (file_exists(__DIR__ . '/../.env')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
            $dotenv->load();
        }

        $containerBuilder = new ContainerBuilder();

        $settings = new Settings();
        $settings($containerBuilder);

        $dependencies = new Dependencies();
        $dependencies($containerBuilder);

        $repositories = new Repositories();
        $repositories($containerBuilder);

        $container = $containerBuilder->build();

        AppFactory::setContainer($container);
        $app = AppFactory::create();

        $middleware = new Middlewares();
        $middleware($app);

        $routes = new Routes();
        $routes($app);

        return $app;
    }

    /**
     * @param array<string> $headers
     * @param array<string> $cookies
     * @param array<string> $serverParams
     * @throws Exception
     */
    protected function createRequest(
        string $method,
        string $path,
        array $headers = ['HTTP_ACCEPT' => 'application/json'],
        array $cookies = [],
        array $serverParams = []
    ): Request {
        $uri = new Uri('', '', 80, $path);
        $handle = fopen('php://temp', 'w+');
        if ($handle === false) {
            throw new Exception('Failed to open php://temp');
        }

        $stream = (new StreamFactory())->createStreamFromResource($handle);

        $h = new Headers();
        foreach ($headers as $name => $value) {
            $h->addHeader($name, $value);
        }

        return new SlimRequest($method, $uri, $h, $cookies, $serverParams, $stream);
    }
}
