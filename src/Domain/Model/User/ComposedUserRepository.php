<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use App\Domain\Event\UserWasSaved;
use Drift\HttpKernel\AsyncKernelEvents;
use React\Promise\PromiseInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ComposedUserRepository implements UserRepository, EventSubscriberInterface
{
    /**
     * @var MemoryUserRepository
     */
    private MemoryUserRepository $memoryRepository;

    /**
     * @var PersistentUserRepository
     */
    private PersistentUserRepository $persistenceRepository;

    /**
     * @param MemoryUserRepository $memoryRepository
     * @param PersistentUserRepository $persistenceRepository
     */
    public function __construct(
        MemoryUserRepository $memoryRepository,
        PersistentUserRepository $persistenceRepository
    ) {
        $this->memoryRepository = $memoryRepository;
        $this->persistenceRepository = $persistenceRepository;
    }

    /**
     * @param User $user
     * @return PromiseInterface
     */
    public function save(User $user): PromiseInterface
    {
        return $this->persistenceRepository->save($user);
    }

    /**
     * @param int $id
     * @return PromiseInterface
     */
    public function find(int $id): PromiseInterface
    {
        return $this->memoryRepository->find($id);
    }

    /**
     * @param User $user
     * @return PromiseInterface
     */
    public function delete(User $user): PromiseInterface
    {
        return $this->persistenceRepository->delete($user);
    }

    /**
     * Load All
     * @return PromiseInterface
     */
    public function loadAllUsersToMemory() : PromiseInterface
    {
        echo 'loadAllUsersToMemory';
        return $this
            ->persistenceRepository
            ->findAll()
            ->then(function(array $users) {
                $this->memoryRepository
                    ->loadFromArray($users);
            });
    }

    /**
     * @return array|\array[][]
     */
    public static function getSubscribedEvents()
    {
        return [
            UserWasSaved::class => [
                ['loadAllUsersToMemory', 0]
            ],
            AsyncKernelEvents::PRELOAD => [
                ['loadAllUsersToMemory', 0]
            ]
        ];
    }
}