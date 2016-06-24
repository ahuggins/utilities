<?php

return [
    'providers' => [
        AHuggins\Utilities\Providers\UtilityServiceProvider::class,
    ],
    'aliases' => [
        'Util' => AHuggins\Utilities\Console\Commands\AddProviders::class,
    ]
];
