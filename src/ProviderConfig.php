<?php

namespace AHuggins\Utilities;

abstract class ProviderConfig
{
    public function __invoke()
    {
        return $this->providers;
    }
}
