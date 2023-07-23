<?php

namespace Shelter\Core\Device;

interface Toggle
{
    public function enable(): void;

    public function disable(): void;
}