<?php

namespace Shelter\Bus;


class StateUpdate
{
    public function __construct(
        private readonly array $properties,
    )
    {
    }

    public function has(string $name): bool
    {
        return array_key_exists($name, $this->properties);
    }

    public function get(string $name): mixed
    {
        return $this->properties[$name];
    }

    public function all(): array
    {
        return $this->properties;
    }

    public function isEmpty(): bool
    {
        return empty($this->properties);
    }
}