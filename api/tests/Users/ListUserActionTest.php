<?php

declare(strict_types=1);

namespace Tests\Users;

use App\Shared\ActionPayload;
use App\Users\User;
use App\Users\UsersService;
use DI\Container;
use Prophecy\PhpUnit\ProphecyTrait;
use Tests\TestCase;

class ListUserActionTest extends TestCase
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
            ->findAll()
            ->willReturn([$user])
            ->shouldBeCalledOnce();

        $container->set(UsersService::class, $usersServiceProphecy->reveal());

        $request = $this->createRequest('GET', '/users');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$user]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        static::assertEquals($serializedPayload, $payload);
    }
}
