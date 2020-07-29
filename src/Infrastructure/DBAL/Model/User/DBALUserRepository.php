<?php

declare(strict_types=1);

namespace App\Infrastructure\DBAL\Model\User;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserNotFoundException;
use App\Domain\Model\User\UserRepository;
use Drift\DBAL\Connection;
use Drift\DBAL\Result;
use React\Promise\PromiseInterface;

class DBALUserRepository implements UserRepository
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

    public function find(int $uid): PromiseInterface
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

    public function delete(User $user): PromiseInterface
    {
        return $this->connection
            ->delete('users', [
                'uid' => $user->uid()
            ])->then(function (Result $result){
               if($result->fetchCount() === 0){
                   throw new UserNotFoundException();
               }
            });
    }
}