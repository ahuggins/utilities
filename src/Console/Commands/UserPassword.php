<?php

namespace AHuggins\Utilities\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class UserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utils:pw 
                            {id? : The id of the user to reset}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset a user password';

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
        $id = $this->argument('id');

        if ($id === null) {
            $this->table(
                ['ID', 'Email'],
                User::all(['id', 'email'])->toArray()
            );
            $id = $this->ask('ID?');
        }

        User::where('id', $id)->update([
            'password' => bcrypt($this->secret('New password?'))
        ]);

        $this->info('User was updated');
    }
}
