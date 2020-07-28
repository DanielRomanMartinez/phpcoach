<?php

namespace Test\Domain\Model\User;

use App\Domain\Model\User\MemoryUserRepository;

class MemoryUserRepositoryTest extends UserRepositoryTest
{
    protected function createRepository(array $users = []): MemoryUserRepository
    {
        return new MemoryUserRepository($users);
    }
}