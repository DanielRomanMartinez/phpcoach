<?php

namespace Test\Domain\Model\User;

use App\Domain\Model\User\MemoryUserRepository;
use App\Domain\Model\User\UserRepository;
use React\EventLoop\LoopInterface;

class MemoryUserRepositoryTest extends UserRepositoryTest
{
    protected function createEmptyRepository(LoopInterface $loop): UserRepository
    {
        return new MemoryUserRepository();
    }
}