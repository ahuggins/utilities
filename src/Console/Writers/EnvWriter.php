<?php

namespace AHuggins\Utilities\Console\Writers;

use Illuminate\Filesystem\Filesystem;

class EnvWriter
{
    /**
     * @var Filesystem
     */
    private $finder;
    /**
     * @var array
     */
    protected $search = [
        "DB_HOST=127.0.0.1",
        "DB_PORT=3306",
        "DB_DATABASE=homestead",
        "DB_USERNAME=homestead",
        "DB_PASSWORD=secret",
    ];

    /**
     * @var string
     */
    protected $file = '.env';

    /**
     * @param Filesystem $finder
     */
    public function __construct(Filesystem $finder)
    {
        $this->finder = $finder;
    }
    /**
     * @param $name
     * @param $username
     * @param $password
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function write($name, $username, $password, $host)
    {
        $environmentFile = $this->finder->get($this->file);
        $replace = [
            "DB_HOST=$host",
            "DB_PORT=3306",
            "DB_DATABASE=$name",
            "DB_USERNAME=$username",
            "DB_PASSWORD=$password",
        ];
        $newEnvironmentFile = str_replace($this->search, $replace, $environmentFile);
        $this->finder->put($this->file, $newEnvironmentFile);
    }
}
