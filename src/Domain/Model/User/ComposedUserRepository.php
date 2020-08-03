<?php

declare(strict_types=1);

namespace App\Domain\Model\User;

use App\Domain\Event\UserWasDeleted;
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
        echo "save \n";
        return $this->persistenceRepository->save($user);
    }

    /**
     * @param string $uid
     * @return PromiseInterface
     */
    public function find(string $uid): PromiseInterface
    {
        echo "find \n";
        return $this->memoryRepository->find($uid);
    }

    /**
     * @param string $uid
     * @return PromiseInterface
     */
    public function delete(string $uid): PromiseInterface
    {
        echo "delete \n";
        return $this->persistenceRepository->delete($uid);
    }

    /**
     * Load All
     * @return PromiseInterface
     */
    public function loadAllUsersToMemory() : PromiseInterface
    {
        echo 'loadAllUsersToMemory \n';
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
            UserWasDeleted::class => [
                ['loadAllUsersToMemory', 0]
            ],
            AsyncKernelEvents::PRELOAD => [
                ['loadAllUsersToMemory', 0]
            ]
        ];
    }
}