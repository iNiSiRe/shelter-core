<?php

namespace Shelter\Core\Device;

use Shelter\Bus\DeviceFactory;
use Shelter\Core\Device;

class Library
{
    /**
     * @var array<DeviceFactory>
     */
    private array $factories = [];

    public function createFromState(string $class, array $state): Device
    {
        return match ($class) {
            'sensor.motion' => new MotionSensor()
        };
    }
}