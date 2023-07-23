<?php

namespace Shelter\Core\Device\Sensor\Contract;

interface TemperatureSensor
{
    public function getTemperature(): float;
}