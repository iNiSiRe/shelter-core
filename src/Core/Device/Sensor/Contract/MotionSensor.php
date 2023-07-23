<?php

namespace Shelter\Core\Device\Sensor\Contract;

interface MotionSensor
{
    public function isActive(): bool;

    public function onMotion(callable $handler): void;
}