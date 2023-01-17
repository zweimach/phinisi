<?php

declare(strict_types=1);

use App\Dependencies;
use App\Middlewares;
use App\Repositories;
use App\Routes;
use App\Settings;
use App\Shared\HttpErrorHandler;
use App\Shared\ResponseEmitter;
use App\Shared\ShutdownHandler;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
}

$containerBuilder = new ContainerBuilder();

if ($_ENV['APP_DEBUG'] !== 'true') {
    $containerBuilder->enableCompilation(__DIR__ . '/../var/cache');
}

$settings = new Settings();
$settings($containerBuilder);

$dependencies = new Dependencies();
$dependencies($containerBuilder);

$repositories = new Repositories();
$repositories($containerBuilder);

$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

/** @var bool $displayErrorDetails */
$displayErrorDetails = $container->get('settings')['displayErrorDetails'];

$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();

$middleware = new Middlewares();
$middleware($app);

$routes = new Routes();
$routes($app);

$errorMiddleware = $app->addErrorMiddleware($displayErrorDetails, false, false);
$errorMiddleware->setDefaultErrorHandler($errorHandler);

$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
