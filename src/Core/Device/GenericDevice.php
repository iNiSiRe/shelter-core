<?php

namespace Shelter\Core\Device;

use Evenement\EventEmitterTrait;
use Shelter\Bus\State;
use Shelter\Core\Device;

class GenericDevice implements Device
{
    use EventEmitterTrait;

    public function __construct(
        protected readonly string  $id,
        protected readonly string  $model,
        protected readonly State $properties
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function getProperties(): array
    {
        return $this->properties->all();
    }

    public function updateProperties(array $properties): void
    {
        $update = $this->properties->update($properties);
        $this->emit('update', [$update]);
    }

    public function onPropertiesUpdate(callable $handler, bool $once = false): void
    {
        if ($once) {
            $this->once('update', $handler);
        } else {
            $this->on('update', $handler);
        }
    }

    public function call(string $method, array $parameters = []): array
    {

    }
}