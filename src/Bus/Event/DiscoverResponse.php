<?php

namespace Shelter\Bus\Event;

use Shelter\Bus\Events;

class DiscoverResponse extends Event
{
    public function __construct(
        public readonly string $device,
        public readonly string $model,
        public readonly array  $properties = []
    )
    {
    }

    public function getName(): string
    {
        return Events::DISCOVER_RESPONSE;
    }
}