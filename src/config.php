<?php

namespace AHuggins\Utilities;

use AHuggins\Utilities\ProviderConfig;

class Config extends ProviderConfig
{
    protected $providers = [
        'providers' => [
            AHuggins\Utilities\Providers\UtilityServiceProvider::class,
        ],
        'aliases' => [
            'Util' => AHuggins\Utilities\Console\Commands\AddProviders::class,
        ]
    ];
}
