<?php


declare(strict_types=1);

namespace App\Controller;

use App\Domain\Command\DeleteUser;
use App\Domain\Model\User\User;
use Drift\CommandBus\Bus\CommandBus;
use Exception;
use React\Promise\PromiseInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteUserController
{

    private $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(string $id, Request $request): PromiseInterface
    {
        return $this->commandBus
            ->execute(
                new DeleteUser(new User($id, json_decode($request->getContent())->name))
            )
            ->then( function () {
                return new JsonResponse(null, 202);
            })->otherwise(function (Exception $e) {
                return new JsonResponse(['message' => $e->getMessage()], 410);
            });
    }
}