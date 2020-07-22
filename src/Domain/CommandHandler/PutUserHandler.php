<?php

namespace App\Domain\CommandHandler;

use App\Domain\Command\PutUser;
use App\Domain\Model\User\User;
use App\Domain\Repository\UserRepository;
use React\Promise\PromiseInterface;
use function React\Promise\resolve;

class PutUserHandler
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function handle(PutUser $putUser) : void
    {
        echo $this->repository->putUser(
            $putUser->getUid(),
            $putUser->getName()
        );
    }
}