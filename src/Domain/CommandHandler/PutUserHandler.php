<?php

namespace App\Domain\CommandHandler;

use App\Domain\Command\PutUser;
use App\Domain\Event\UserWasSaved;
use App\Domain\Model\User\UserRepository;
use Drift\EventBus\Bus\EventBus;
use React\Promise\PromiseInterface;

/**
 * Class PutUserHandler
 * @package App\Domain\CommandHandler
 */
class PutUserHandler
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var EventBus
     */
    private $eventBus;

    /**
     * PutUserHandler constructor.
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
     * @param PutUser $putUser
     * @return PromiseInterface
     */
    public function handle(PutUser $putUser) : PromiseInterface
    {
        $user = $putUser->getUser();

        return $this->repository
            ->save($user)
            ->then(function() use ($user) {
                return $this->eventBus->dispatch(new UserWasSaved($user));
        });

    }
}