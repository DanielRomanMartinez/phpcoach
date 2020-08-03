<?php

declare(strict_types=1);

namespace App\Infrastructure\DBAL\Model\User;

use App\Domain\Model\User\PersistentUserRepository;
use App\Domain\Model\User\User;
use App\Domain\Model\User\UserNotFoundException;
use Drift\DBAL\Connection;
use Drift\DBAL\Result;
use React\Promise\PromiseInterface;

class DBALUserRepository implements PersistentUserRepository
{
    /**
     * @var Connection
     */
    private Connection $connection;

    /**
     * DBALUserRepository constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): PromiseInterface
    {
        return $this
            ->connection
            ->upsert('users', [
                'uid' => $user->uid(),

            ], [
                'name' => $user->name(),
            ]);
    }

    public function find(string $uid): PromiseInterface
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->select('*')
            ->from('users', 'u')
            ->where('u.uid = ?')
            ->setParameters([$uid]);

        return $this->connection
            ->query($queryBuilder)
            ->then(function(Result $result) {
                 $userAsArray = $result->fetchFirstRow();

                 if(null === $userAsArray){
                     throw new UserNotFoundException();
                 }
                 return new User(
                     $userAsArray['uid'],
                     $userAsArray['name']
                 );
            });
    }

    public function delete(string $uid): PromiseInterface
    {
        return $this->connection
            ->delete('users', [
                'uid' => $uid
            ]);
    }

    /**
     * Find allpersis
     * @return PromiseInterface
     */
    public function findAll(): PromiseInterface
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->select('*')
            ->from('users', 'u');

        return $this->connection
            ->query($queryBuilder)
            ->then(function(Result $result) {
                $usersAsArray = $result->fetchAllRows();
                $users = [];
                foreach($usersAsArray as $userAsArray){
                    $users[$userAsArray['uid']] = new User(
                        $userAsArray['uid'],
                        $userAsArray['name']
                    );
                }
                return $users;
            });
    }
}