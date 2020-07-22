<?php

namespace App\Domain\QueryHandler;

use App\Domain\Query\GetUser;
use App\Domain\Repository\UserRepository;
use App\Domain\Model\User\UserNotFoundException;
use React\Promise\PromiseInterface;
use function React\Promise\reject;
use function React\Promise\resolve;

final class GetUserHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * DeleteValueHandler constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle DeleteValue.
     *
     * @param GetUser $getUser
     * @return PromiseInterface
     */
    public function handle(GetUser $getUser): PromiseInterface
    {
        $user = $this->userRepository->get($getUser->uid());
        if(!$user) {
            return reject(new UserNotFoundException());
        }

        return resolve($user);
    }
}