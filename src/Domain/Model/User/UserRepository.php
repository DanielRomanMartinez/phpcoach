<?php

namespace App\Domain\Model\User;

use React\Promise\PromiseInterface;

/**
 * Class UserRepository
 * @package App\Domain\Repository
 */
interface UserRepository
{
    /**
     * @param User $user
     * @return PromiseInterface
     */
    public function save(User $user): PromiseInterface;

    /**
     * @param string $uid
     * @return PromiseInterface
     */
    public function find(string $uid): PromiseInterface;

    /**
     * @param string $uid
     * @return PromiseInterface
     */
    public function delete(string $uid): PromiseInterface;

}