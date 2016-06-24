<?php

namespace AHuggins\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utils:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a basic user';

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
        User::create([
            'name' => $this->ask('Name?'),
            'email' => $this->ask('Email address?'),
            'password' => bcrypt($this->secret('Password?'))
        ]);
        
        $this->info('User saved');
    }
}
