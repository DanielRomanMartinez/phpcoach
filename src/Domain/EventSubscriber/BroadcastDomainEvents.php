<?php

declare(strict_types=1);

namespace App\Domain\EventSubscriber;

use App\Domain\Event\UserWasSaved;
use Drift\HttpKernel\Event\DomainEventEnvelope;
use Drift\Websocket\Connection\Connections;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class BroadcastDomainEvents
 * @package App\Domain\EventSubscriber
 */
class BroadcastDomainEvents implements EventSubscriberInterface
{

    /**
     * @var Connections
     */
    private Connections $connections;

    public function __construct(Connections $eventsConnections)
    {
        $this->connections = $eventsConnections;
    }

    /**
     * @param DomainEventEnvelope $eventEnvelope
     */
    public function broadcastUserWasSaved(DomainEventEnvelope $eventEnvelope)
    {
        /** @var @UserWasSaved $event $event */
        $event = $eventEnvelope->getDomainEvent();

        $this->connections
            ->broadcast(json_encode([
                    'type' => 'user_was_saved',
                    'uid' => $event->getUser()->getUid(),
                    'name' => $event->getUser()->getName(),
                ]));

    }

    public static function getSubscribedEvents()
    {
        return [
            UserWasSaved::class => [
                ['broadcastUserWasSaved', 0]
            ]
        ];
    }
}