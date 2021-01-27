<?php

namespace App\Application\Command;

interface CommandBus
{
    /**
     * @param Command $command
     */
    public function dispatch($command): void;
}
