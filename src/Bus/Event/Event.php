<?php

namespace Shelter\Bus\Event;

use inisire\NetBus\Event\EventInterface;

abstract class Event implements EventInterface
{
    public function getData(): array
    {
        return get_object_vars($this);
    }
}