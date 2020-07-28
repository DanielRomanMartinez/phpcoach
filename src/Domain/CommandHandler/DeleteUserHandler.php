<?php

declare(strict_types=1);

namespace App\Domain\CommandHandler;

use App\Domain\Command\DeleteUser;
use App\Domain\Model\User\UserRepository;
use React\Promise\PromiseInterface;

class DeleteUserHandler
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(DeleteUser $command): PromiseInterface
    {
        return $this->userRepository->delete($command->getUser());
    }
}