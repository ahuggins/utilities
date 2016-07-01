<?php

namespace AHuggins\Utilities\Console\Commands;

use PDOException;
use Illuminate\Console\Command;
use AHuggins\Utilities\Console\Writers\EnvWriter;
use Illuminate\Contracts\Config\Repository as Config;

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
        parent::__construct();
        $this->config = $config;
        $this->env = $env;
    }

    /**
     * @var Command
     */
    protected $command;

    /**
     * Handle the Command
     * @return mixed
     */
    public function handle()
    {
        if (! $this->confirm('Set up DB creds now? [y|N]')) {
            return;
        }

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
                $this->error("Please ensure your database credentials are valid.");
            }
        }

        $this->env->write($name, $user, $password, $host);

        $this->info('Database successfully configured');
    }

    /**
     * @return string
     */
    protected function askDatabaseHost()
    {
        $host = $this->ask('Enter your database host', 'localhost');

        return $host;
    }

    /**
     * @return string
     */
    protected function askDatabaseName()
    {
        do {
            $name = $this->ask('Enter your database name', 'homestead');
            if ($name == '') {
                $this->error('Database name is required');
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
            $user = $this->ask('Enter your database username', 'homestead');
            if ($user == '') {
                $this->error('Database username is required');
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
        $databasePassword = $this->ask('Enter your database password (enter "<none>" for no password)', 'secret');

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
