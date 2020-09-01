<?php

declare(strict_types=1);

namespace Tests\Shared;

use App\Shared\Action;
use App\Shared\ActionPayload;
use DateTimeImmutable;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class ActionTest extends TestCase
{
    public function testActionSetsHttpCodeInRespond(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $logger = null;
        if ($container !== null) {
            $logger = $container->get(LoggerInterface::class);
        }

        $testAction = new class($logger) extends Action {
            public function __construct(LoggerInterface $loggerInterface)
            {
                parent::__construct($loggerInterface);
            }

            public function action(): Response
            {
                return $this->respond(
                    new ActionPayload(
                        202,
                        [
                            'willBeDoneAt' => (new DateTimeImmutable())->format(DateTimeImmutable::ATOM)
                        ]
                    )
                );
            }
        };

        $app->get('/test-action-response-code', $testAction);
        $request = $this->createRequest('GET', '/test-action-response-code');
        $response = $app->handle($request);

        static::assertEquals(202, $response->getStatusCode());
    }

    public function testActionSetsHttpCodeRespondData(): void
    {
        $app = $this->getAppInstance();
        $container = $app->getContainer();
        $logger = null;
        if ($container !== null) {
            $logger = $container->get(LoggerInterface::class);
        }

        $testAction = new class($logger) extends Action {
            public function __construct(LoggerInterface $loggerInterface)
            {
                parent::__construct($loggerInterface);
            }

            public function action(): Response
            {
                return $this->respondWithData(
                    [
                        'willBeDoneAt' => (new DateTimeImmutable())->format(DateTimeImmutable::ATOM)
                    ],
                    202
                );
            }
        };

        $app->get('/test-action-response-code', $testAction);
        $request = $this->createRequest('GET', '/test-action-response-code');
        $response = $app->handle($request);

        static::assertEquals(202, $response->getStatusCode());
    }
}
