<?php

declare(strict_types=1);

namespace Tests\Users;

use App\Shared\ActionError;
use App\Shared\ActionPayload;
use App\Shared\HttpErrorHandler;
use App\Users\User;
use App\Users\UserNotFoundException;
use App\Users\UsersService;
use DI\Container;
use Prophecy\PhpUnit\ProphecyTrait;
use Slim\Middleware\ErrorMiddleware;
use Tests\TestCase;

class ViewUserActionTest extends TestCase
{
    use ProphecyTrait;

    public function testAction(): void
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = new User(1, 'bill.gates', 'bill@gates.com', 'billgates', 'Bill', 'Gates');

        $usersServiceProphecy = $this->prophesize(UsersService::class);
        $usersServiceProphecy
            ->findUserOfId(1)
            ->willReturn($user)
            ->shouldBeCalledOnce();

        $container->set(UsersService::class, $usersServiceProphecy->reveal());

        $request = $this->createRequest('GET', '/users/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, $user);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        static::assertEquals($serializedPayload, $payload);
    }

    public function testActionThrowsUserNotFoundException(): void
    {
        $app = $this->getAppInstance();

        $callableResolver = $app->getCallableResolver();
        $responseFactory = $app->getResponseFactory();

        $errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);
        $errorMiddleware = new ErrorMiddleware($callableResolver, $responseFactory, true, false, false);
        $errorMiddleware->setDefaultErrorHandler($errorHandler);

        $app->add($errorMiddleware);

        /** @var Container $container */
        $container = $app->getContainer();

        $usersServiceProphecy = $this->prophesize(UsersService::class);
        $usersServiceProphecy
            ->findUserOfId(1)
            ->willThrow(new UserNotFoundException())
            ->shouldBeCalledOnce();

        $container->set(UsersService::class, $usersServiceProphecy->reveal());

        $request = $this->createRequest('GET', '/users/1');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedError = new ActionError(ActionError::RESOURCE_NOT_FOUND, 'The user you requested does not exist.');
        $expectedPayload = new ActionPayload(404, null, $expectedError);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        static::assertEquals($serializedPayload, $payload);
    }
}
