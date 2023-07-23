<?php

namespace Shelter\Core;

interface DeviceRegistry
{
    public function find(string $id): ?Device;

    /**
     * @return iterable<Device>
     */
    public function findAll(): iterable;
}