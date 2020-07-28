<?php

namespace App\Domain\CommandHandler;

use App\Domain\Command\PutUser;
use App\Domain\Model\User\User;
use App\Domain\Model\User\UserRepository;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;

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
     * PutUserHandler constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    /**
     * @param PutUser $putUser
     * @return PromiseInterface
     */
    public function handle(PutUser $putUser) : PromiseInterface
    {
        return $this->repository->save(
            $putUser->getUser()
        );
    }
}