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
     * @param int $id
     * @return PromiseInterface
     */
    public function find(int $id): PromiseInterface;

    /**
     * @param User $user
     * @return PromiseInterface
     */
    public function delete(User $user): PromiseInterface;

}