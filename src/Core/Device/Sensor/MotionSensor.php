<?php

namespace Shelter\Core\Device\Sensor;

use Shelter\Bus\State;
use Shelter\Bus\StateUpdate;
use Shelter\Core\Device;

class MotionSensor extends Device\GenericDevice implements Contract\MotionSensor
{
    public function __construct(
        string $id,
        string $model,
        State  $properties
    )
    {
        parent::__construct($id, $model, $properties);

        $this->onPropertiesUpdate(function (StateUpdate $update) {
            if ($update->has('motion')) {
                $this->emit('motion', [$update->get('motion')]);
            }
        });
    }

    public function isActive(): bool
    {
        return $this->properties->get('motion', false) === true;
    }

    public function getBatteryVoltage(): float
    {
        return $this->properties->get('battery_voltage', 0.0);
    }

    public function onMotion(callable $handler): void
    {
        $this->on('motion', $handler);
    }
}