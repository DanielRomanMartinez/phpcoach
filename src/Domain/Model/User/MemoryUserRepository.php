<?php

namespace App\Domain\Model\User;

use React\Promise\PromiseInterface;
use function React\Promise\reject;
use function React\Promise\resolve;

class MemoryUserRepository implements UserRepository
{
    protected $users = [];


    /**
     * @param array $users
     */
    public function loadFromArray(array $users) : void
    {
        $this->users = $users;
    }

    /**
     * @param User $user
     * @return PromiseInterface
     */
    public function save(User $user): PromiseInterface
    {
        $this->users[$user->uid()] = $user;

        return resolve();
    }

    /**
     * @param string $uid
     * @return PromiseInterface
     */
    public function find(string $uid): PromiseInterface
    {
        echo 'find';
        return array_key_exists($uid, $this->users)
            ? resolve($this->users[$uid])
            : reject(new UserNotFoundException());
    }

    /**
     * @param string $uid
     * @return PromiseInterface
     */
    public function delete(string $uid): PromiseInterface
    {
        echo 'delete 2';
        if (array_key_exists($uid, $this->users)) {
            unset($this->users[$uid]);
            echo 'resolve';
            return resolve(true);
        }

        return reject(new UserNotFoundException());
    }
}