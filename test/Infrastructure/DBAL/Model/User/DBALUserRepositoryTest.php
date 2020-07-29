<?php

namespace Test\Infrastructure\DBAL\Model\User;

use App\Domain\Model\User\UserRepository;
use App\Infrastructure\DBAL\Model\User\DBALUserRepository;
use Drift\DBAL\Connection;
use Doctrine\DBAL\Platforms\SqlitePlatform;
use Drift\DBAL\Credentials;
use Drift\DBAL\Driver\SQLite\SQLiteDriver;
use React\EventLoop\LoopInterface;
use Test\Domain\Model\User\UserRepositoryTest;

class DBALUserRepositoryTest extends UserRepositoryTest
{

    protected function createEmptyRepository(LoopInterface $loop): UserRepository
    {
        $sqlitePlatform = new SqlitePlatform();
        $sqliteDriver = new SQLiteDriver($loop);
        $credentials = new Credentials(
          '',
          '',
          'root',
          'root',
          ':memory:'
        );

        $connection = Connection::createConnected(
            $sqliteDriver,
            $credentials,
            $sqlitePlatform
        );

        $connection->createTable('users', [
            'uid'  => 'string',
            'name' => 'string'
        ]);

        return new DBALUserRepository($connection);
    }
}