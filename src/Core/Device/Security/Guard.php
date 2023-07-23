<?php

namespace Shelter\Core\Device\Security;

interface Guard
{
    public function isGuardActive(): bool;
}