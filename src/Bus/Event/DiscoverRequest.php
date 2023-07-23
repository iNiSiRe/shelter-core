<?php

namespace Shelter\Bus\Event;

use Shelter\Bus\Events;

class DiscoverRequest extends Event
{
    public function __construct(
        public readonly string $source,
    )
    {
    }

    public function getName(): string
    {
        return Events::DISCOVER_REQUEST;
    }
}