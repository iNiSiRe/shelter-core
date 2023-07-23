<?php

namespace Shelter\Bus;


class MutableState implements State
{
    public function __construct(
        private array $properties,
    )
    {
    }

    public function get(string $name, mixed $default): mixed
    {
        return $this->properties[$name] ?? $default;
    }

    public function set(string $name, mixed $value): void
    {
        $this->properties[$name] = $value;
    }

    public function all(): array
    {
        return $this->properties;
    }

    public function update(array $properties): StateUpdate
    {
        $update = [];

        foreach ($properties as $k => $v) {
            $current = $this->properties[$k] ?? null;
            if ($current !== $v) {
                $update[$k] = $v;
                $this->properties[$k] = $v;
            }
        }

        return new StateUpdate($update);
    }
}