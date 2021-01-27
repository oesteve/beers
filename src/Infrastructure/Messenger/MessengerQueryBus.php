<?php

namespace App\Infrastructure\Messenger;

use App\Application\Query\QueryBus;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerQueryBus implements QueryBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageQueryBus)
    {
        $this->messageBus = $messageQueryBus;
    }

    /**
     * {@inheritDoc}
     */
    public function query($query)
    {
        return $this->handle($query);
    }
}
