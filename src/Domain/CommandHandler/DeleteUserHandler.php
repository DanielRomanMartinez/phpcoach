<?php

declare(strict_types=1);

namespace App\Domain\CommandHandler;

use App\Domain\Command\DeleteUser;
use App\Domain\Event\UserWasDeleted;
use App\Domain\Model\User\UserRepository;
use Drift\EventBus\Bus\EventBus;
use React\Promise\PromiseInterface;

class DeleteUserHandler
{
    /**
     * @var UserRepository
     */
    private UserRepository $repository;

    /**
     * @var EventBus
     */
    private EventBus $eventBus;

    /**
     * DeleteUserHandler constructor.
     * @param UserRepository $userRepository
     * @param EventBus $eventBus
     */
    public function __construct(
        UserRepository $userRepository,
        EventBus $eventBus
    ) {
        $this->repository = $userRepository;
        $this->eventBus = $eventBus;
    }

    /**
     * @param DeleteUser $command
     * @return PromiseInterface
     */
    public function handle(DeleteUser $command): PromiseInterface
    {
        echo 'hi';
        return $this->repository
            ->delete($command->uid())
            ->then(function() {
                echo 'hi2';
                return $this->eventBus->dispatch(new UserWasDeleted());
            });
    }
}