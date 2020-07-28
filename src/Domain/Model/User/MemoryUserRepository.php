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

    public function find(int $uid): PromiseInterface
    {
        return array_key_exists($uid, $this->users)
            ? resolve($this->users[$uid])
            : reject(new UserNotFoundException());
    }

    public function delete(User $user): PromiseInterface
    {
        if (array_key_exists($user->uid(), $this->users)) {
            unset($this->users[$user->uid()]);
            return resolve(true);
        }

        return reject(new UserNotFoundException());
    }
}