<?php

namespace Shelter\Bus;

use Evenement\EventEmitterInterface;
use Evenement\EventEmitterTrait;
use inisire\NetBus\Event\EventBusInterface;
use Shelter\Bus\Event\StateUpdateEvent;

interface State
{
    public function get(string $name, mixed $default): mixed;

    public function all(): array;

    public function update(array $properties): StateUpdate;
}