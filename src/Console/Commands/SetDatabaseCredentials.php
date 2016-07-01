<?php

namespace AHuggins\Utilities\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Config\Repository as Config;
use AHuggins\Utilities\Console\Writers\EnvWriter;
use PDOException;

class SetDatabaseCredentials extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utils:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add the DB credentials to the env file.';

    /**
     * @var
     */
    protected $config;

    /**
     * @var EnvWriter
     */
    protected $env;

    /**
     * @param Config        $config
     * @param EnvWriter $env
     */
    public function __construct(Config $config, EnvWriter $env)
    {
        $this->config = $config;
        $this->env = $env;
    }

    /**
     * @var Command
     */
    protected $command;

    /**
     * Handle the Command
     * @param  Command $command
     * @return mixed
     */
    public function handle(Command $command)
    {
        $this->command = $command;

        $connected = false;

        while (! $connected) {
            $host = $this->askDatabaseHost();

            $name = $this->askDatabaseName();

            $user = $this->askDatabaseUsername();

            $password = $this->askDatabasePassword();

            $this->setLaravelConfiguration($name, $user, $password, $host);

            if ($this->databaseConnectionIsValid()) {
                $connected = true;
            } else {
                $command->error("Please ensure your database credentials are valid.");
            }
        }

        $this->env->write($name, $user, $password, $host);

        $command->info('Database successfully configured');
    }

    /**
     * @return string
     */
    protected function askDatabaseHost()
    {
        $host = $this->command->ask('Enter your database host', 'localhost');

        return $host;
    }

    /**
     * @return string
     */
    protected function askDatabaseName()
    {
        do {
            $name = $this->command->ask('Enter your database name', 'homestead');
            if ($name == '') {
                $this->command->error('Database name is required');
            }
        } while (!$name);

        return $name;
    }

    /**
     * @param
     * @return string
     */
    protected function askDatabaseUsername()
    {
        do {
            $user = $this->command->ask('Enter your database username', 'homestead');
            if ($user == '') {
                $this->command->error('Database username is required');
            }
        } while (!$user);

        return $user;
    }

    /**
     * @param
     * @return string
     */
    protected function askDatabasePassword()
    {
        $databasePassword = $this->command->ask('Enter your database password (leave <none> for no password)', 'secret');

        return ($databasePassword === '<none>') ? '' : $databasePassword;
    }

    /**
     * @param $name
     * @param $user
     * @param $password
     */
    protected function setLaravelConfiguration($name, $user, $password, $host)
    {
        $this->config['database.connections.mysql.host'] = $host;
        $this->config['database.connections.mysql.database'] = $name;
        $this->config['database.connections.mysql.username'] = $user;
        $this->config['database.connections.mysql.password'] = $password;
    }

    /**
     * Is the database connection valid?
     * @return bool
     */
    protected function databaseConnectionIsValid()
    {
        try {
            app('db')->reconnect();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
