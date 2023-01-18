<?php

declare(strict_types=1);

namespace App\Shared;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

abstract class Action
{
    protected LoggerInterface $logger;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected Request $request;

    /**
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected Response $response;

    /**
     * @var array<mixed>
     * @psalm-suppress PropertyNotSetInConstructor
     */
    protected array $arguments;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param array<mixed> $arguments
     * @throws HttpNotFoundException
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, Response $response, array $arguments): Response
    {
        $this->request = $request;
        $this->response = $response;
        $this->arguments = $arguments;

        try {
            return $this->action();
        } catch (DomainRecordNotFoundException $e) {
            throw new HttpNotFoundException($this->request, $e->getMessage());
        }
    }

    /**
     * @throws DomainRecordNotFoundException
     * @throws HttpBadRequestException
     */
    abstract protected function action(): Response;

    /**
     * @return null|array<mixed>|object
     */
    protected function getFormData()
    {
        return $this->request->getParsedBody();
    }

    /**
     * @throws HttpBadRequestException
     */
    protected function resolveArguments(string $name): mixed
    {
        if (! isset($this->arguments[$name])) {
            throw new HttpBadRequestException($this->request, "Could not resolve argument `{$name}`.");
        }

        return $this->arguments[$name];
    }

    /**
     * @param mixed $data
     */
    protected function respondWithData($data = null, int $statusCode = 200): Response
    {
        $payload = new ActionPayload($statusCode, $data);

        return $this->respond($payload);
    }

    protected function respond(ActionPayload $payload): Response
    {
        $json = json_encode($payload, JSON_PRETTY_PRINT);
        if ($json !== false) {
            $this->response->getBody()->write($json);
        }

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($payload->getStatusCode());
    }
}
