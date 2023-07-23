<?php

namespace Shelter\Core\Device\Security;

interface Alarm
{
    public function enableAlarm(?float $duration = null): void;

    public function disableAlarm(): void;

    public function isEnabled(): bool;
}