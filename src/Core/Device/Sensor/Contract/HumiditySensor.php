<?php

namespace Shelter\Core\Device\Sensor\Contract;

interface HumiditySensor
{
    public function getHumidity(): float;
}