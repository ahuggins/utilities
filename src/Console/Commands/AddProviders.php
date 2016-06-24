<?php

namespace AHuggins\Utilities\Console\Commands;

use Illuminate\Console\Command;

class AddProviders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utils:providers {namespace : The namespace of package with escaped slash}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add the providers and aliases to the app.php file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $namespace = $this->argument('namespace') . '\Config';
        $providers = (new $namespace)();
        if (array_key_exists('providers', $providers)) {
            dump($providers['providers']);
        }

        if (array_key_exists('aliases', $providers)) {
            dd($providers['aliases']);
        }
    }
}
