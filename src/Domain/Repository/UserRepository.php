<?php

namespace App\Domain\Repository;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserNotFoundException;

/**
 * Class UserRepository
 * @package App\Domain\Repository
 */
class UserRepository
{
    /**
     * @var array
     */
    private $users = [];

    public function __construct()
    {
        array_push($this->users, new User("1", "Dani Roman"));
        array_push($this->users, new User('2', 'Marc Morera'));
        array_push($this->users, new User('3', 'Sergi Fernandez'));
        array_push($this->users, new User('4', 'Kevin Hernandez'));
    }

    /**
     * Get value given an id.
     *
     * @param string $uid
     * @return User|null
     */
    public function get(string $uid): ?User
    {
        if (!array_key_exists($uid, $this->users)) {
            return null;
        }
        return $this->users[$uid];
    }

    /**
     * Get all users
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->users;
    }

    /**
     * @param string $uid
     * @param string $name
     */
    public function putUser(string $uid, string $name): string
    {
        return "\n\nPut User with uid: $uid and name $name \n\n";
    }
}