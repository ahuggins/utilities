<?php

namespace AHuggins\Utilities\Providers;

use Illuminate\Support\ServiceProvider;
use AHuggins\Utilities\Console\Commands\CreateUser;
use AHuggins\Utilities\Console\Commands\UserPassword;
use AHuggins\Utilities\Console\Commands\AddProviders;

class UtilityServiceProvider extends ServiceProvider
{
    protected $commands = [
        CreateUser::class,
        UserPassword::class,
        AddProviders::class,
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }
}
