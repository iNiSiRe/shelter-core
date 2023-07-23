<?php

namespace Shelter\Core\Device\Sensor\Contract;

interface MagnetSensor
{
    public function isOpen(): bool;

    public function onOpenUpdate(callable $handler): void;
}