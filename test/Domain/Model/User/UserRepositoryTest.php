<?php

namespace Test\Domain\Model\User;

use App\Domain\Model\User\User;
use App\Domain\Model\User\UserNotFoundException;
use App\Domain\Model\User\UserRepository;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use function Clue\React\Block\await;

abstract class UserRepositoryTest extends TestCase
{
    protected $loop;

    public function setUp(): void
    {
        $this->loop = Factory::create();
    }

    /**
     * @param LoopInterface $loop
     * @return UserRepository
     */
    abstract protected function createEmptyRepository(LoopInterface $loop) : UserRepository;

    public function testUserNotExist()
    {
        $repository = $this->createEmptyRepository($this->loop);

        $promise = $repository->find('123');
        $this->expectException(UserNotFoundException::class);
        await($promise, $this->loop);
    }

    public function testUserExists()
    {
        $repository = $this->createEmptyRepository($this->loop);

        $promise = $repository
            ->save(new User('123', 'Percebes'))
            ->then(function() use ($repository) {
                return $repository->find('123');
            });

        $user = await($promise, $this->loop);
        $this->assertEquals('123', $user->uid());
    }

    public function testUserTwice()
     {
         $repository = $this->createEmptyRepository($this->loop);
         $user1 = new User('123', 'Percebes');
         await($repository->save($user1), $this->loop);

         $user2 = new User('123', 'Engonga');
         await($repository->save($user2), $this->loop);

         $promise2 = $repository->find(123);
         $user = await($promise2, $this->loop);

         $this->assertEquals('Engonga', $user->name());
     }

    public function testUserFindProperly()
    {
        $repository = $this->createEmptyRepository($this->loop);
        $user1 = new User('123', 'Percebes');
        await($repository->save($user1), $this->loop);

        $promise = $repository->find('456');
        $this->expectException(UserNotFoundException::class);
        await($promise, $this->loop);
    }

    public function testUserDeleted()
    {
        $repository = $this->createEmptyRepository($this->loop);

        $promise = $repository
            ->save(new User('123', 'Percebes'))
            ->then(function() use ($repository) {
                return $repository->find('123');
            });

        $user = await($promise, $this->loop);
        $this->assertEquals('123', $user->uid());

        $this->expectException(UserNotFoundException::class);
        await($repository->delete($user), $this->loop);
    }
}