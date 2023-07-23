<?php

namespace Shelter\Core\Device\Sensor;

use Shelter\Bus\State;
use Shelter\Bus\StateUpdate;
use Shelter\Core\Device;

class MagnetSensor extends Device\GenericDevice implements Contract\MagnetSensor
{
    public function __construct(
        string $id,
        string $model,
        State  $properties
    )
    {
        parent::__construct($id, $model, $properties);

        $this->onPropertiesUpdate(function (StateUpdate $update) {
            if ($update->has('open')) {
                $this->emit('open', [$update->get('open')]);
            }
        });
    }

    public function isOpen(): bool
    {
        return $this->properties->get('open', false) === true;
    }

    public function getBatteryVoltage(): float
    {
        return $this->properties->get('battery_voltage', 0.0);
    }

    public function onOpenUpdate(callable $handler): void
    {
        $this->on('open', $handler);
    }
}