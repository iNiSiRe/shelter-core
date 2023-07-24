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
            if ($update->has('motionAt')) {
                $this->emit('motion', [$update->get('motionAt')]);
            }
        });
    }

    public function isActive(): bool
    {
        $motionAt = $this->properties->get('motionAt', 0);

        return (time() - $motionAt) < 60;
    }

    public function triggerMotion(): void
    {
        $this->properties->update(['motionAt' => time()]);
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