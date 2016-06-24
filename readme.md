# Laravel Artisan Utilities

## Commands
* Create User
* Reset Password
* Auto Service Providers

## Basic Description

I have found myself doing pretty common things over and over when using Laravel. Things, that every time I do, I think "there should be a simpler way to do this." This Utilities package is my attempt to make those things as easy as I can and provide that "simpler way." As of June 24, 2016 that was a couple Artisan commands to make dealing with users locally just a little easier. This could be made a `dev` only package, but if someone has access to Artisan on your server, they can pretty much do what they want already.

## Installation

The usual:

`composer require ahuggins/utilities`

After that installs, add the following to your `config/app.php` file in the providers array:

`AHuggins\Utilities\Providers\UtilityServiceProvider::class,`

## Create User

The Create User command is pretty easy. Provided you have a DB connection setup in Laravel, you simply run:

`php artisan utils:create-user` and the command will prompt you for the right information.

> Note: the password field does not show typing to prevent anyone reading the screen. Just like the terminal it hides the indication of typing, but it is working.

It asks for `name`, `email`, and `password`.

## Reset Password

The Reset Password command has a nice little feature. Here's how to use it:

`php artisan utils:pw`

If you run that, it will show you a table of the users in your Users table. I envision this to be used in development more than anything, so I am anticipating that you will only have a few test users in your db (I present all the users, so that could be cumbersome). Then the command asks for the ID of the user you want to change the password for. Type in the id, hit enter. Then it will ask you to enter the password, (just like the Create User command, the typing is hidden but it is working), finish typing, hit enter.

Now if you already know the id of the user you want to edit. Simply use the command like this:

`php artisan utils:pw 1`

Where `1` is replaced by the id of the user you want to edit.

## Auto Service Providers (In Process)

I am trying to add the ability for other package authors to automate the step of adding the releavant class paths to the providers and aliases arrays in config/app.php.

> This command will not work as of 6/24/2016.

Basically I am thinking that if they made the `ahuggins/utilities` package a dependency in their package, and then had a file in the root of their `src` directory named config.php, with contents like this:

```
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

```

Obviously, you would have to update the namespace for the package, as well as the contents of the `$providers` array. But the command I build would be able to grab the values from the config.php file. Then using the composer scripts section of a composer.json file, you could tell Composer to execute a command (the command I am building) after install. The command would then grab the values and update the appropriate array checking for duplicates.

One issue I see initially, is that if the ahuggins/utilities package is not installed, then you have to manually add it for this convenience. This could be easily incorporated into core Laravel so this is not an issue, but I am hoping to figure out a nice easy way to get around that.

Seems like a small thing, but is one less kind of tedious thing you have to do when installing a package. This will be very Laravel specific, but if other packages added this config.php file to their repo's as well as the composer.json part, we could eliminate a couple copy and paste steps that are just minor annoyances.
