<?php

namespace App\Domain\Model\User;

use App\Domain\Model\User\UserRepository;
use React\Promise\PromiseInterface;
use function React\Promise\reject;
use function React\Promise\resolve;

class MemoryUserRepository implements UserRepository
{
    protected $users = [];

    public function __construct(array $users = [])
    {
        $this->users = $users;
    }

    public function save(User $user): PromiseInterface
    {
        $this->users[$user->uid()] = $user;

        return resolve();
    }

    public function find(int $id): PromiseInterface
    {
        return isset($this->users[$id])
            ? resolve($this->users[$id])
            : reject(new UserNotFoundException());
    }

    public function delete(User $user): PromiseInterface
    {
        if (isset($this->users[$user->uid()])) {
            unset($this->users[$user->uid()]);
            return resolve(true);
        }

        return reject(new UserNotFoundException());
    }
}