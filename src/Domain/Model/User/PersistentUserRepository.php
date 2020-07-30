<?php


namespace App\Domain\Model\User;


use React\Promise\PromiseInterface;

interface PersistentUserRepository extends UserRepository
{
    /**
     * @return PromiseInterface
     */
    public function findAll() : PromiseInterface;
}