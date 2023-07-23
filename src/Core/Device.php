<?php

namespace Shelter\Core;

interface Device
{
    public function getId(): string;

    public function getModel(): string;

    public function getProperties(): array;

    public function updateProperties(array $properties): void;

    public function onPropertiesUpdate(callable $handler): void;
}