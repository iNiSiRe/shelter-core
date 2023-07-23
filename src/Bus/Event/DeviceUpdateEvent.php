<?php

namespace Shelter\Bus\Event;

use Shelter\Bus\Events;

class DeviceUpdateEvent extends Event
{
    public function __construct(
        public readonly string $device,
        public readonly array $properties = []
    )
    {
    }

    public function getName(): string
    {
        return Events::DEVICE_UPDATE;
    }
}