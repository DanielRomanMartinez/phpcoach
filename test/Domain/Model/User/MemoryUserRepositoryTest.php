<?php

namespace Test\Domain\Model\User;

use App\Domain\Model\User\MemoryUserRepository;

class MemoryUserRepositoryTest extends UserRepositoryTest
{
    protected function createRepository(array $users = []): UserRepository
    {
        return new MemoryUserRepository($users);
    }
}