<?php

namespace Shelter\Bus;

use Shelter\Core\Device;

class DeviceFactory
{
    public function createByModel(string $model, string $id, State $state): Device
    {
        return match ($model) {
            'sensor.magnet' => new Device\Sensor\MagnetSensor($id, $model, $state),
            'sensor.motion' => new Device\Sensor\MotionSensor($id, $model, $state),
            default => new Device\GenericDevice($id, $model, $state)
        };
    }
}