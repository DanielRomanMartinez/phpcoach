<?php

declare(strict_types=1);

namespace App\Domain\EventSubscriber;

use Drift\Websocket\Event\WebsocketConnectionOpened;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drift\Websocket\Connection\Connection;

class BroadcastNewConnections implements EventSubscriberInterface
{

    /**
     *
     */
    public function broadcastNewConnection(WebsocketConnectionOpened $event)
    {
        $connections = $event->getConnections();

        $connections
            ->broadcast(json_encode([
                'type' => 'new_connection',
                'connection' => Connection::getConnectionHash($event->getNewConnection())
            ]));

    }

    /**
     * @return array|\array[][]
     */
    public static function getSubscribedEvents() : array
    {
        return [
            WebsocketConnectionOpened::class => [
                ['broadcastNewConnection', 0]
            ]
        ];
    }
}