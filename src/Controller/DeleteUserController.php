<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Command\DeleteUser;
use Drift\CommandBus\Bus\CommandBus;
use Exception;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteUserController
{

    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(string $uid, Request $request): PromiseInterface
    {
        return $this->commandBus
            ->execute(
                new DeleteUser($uid)
            )
            ->then( function () {
                return new JsonResponse(null, 202);
            })->otherwise(function (Exception $e) {
                return new JsonResponse(['message' => $e->getMessage()], 410);
            });
    }
}