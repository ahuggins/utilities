# Laravel Artisan Utilities

## Commands
* Create User
* Reset Password

## Basic Description

I have found myself doing pretty common things over and over when using Laravel. Things, that every time I do, I think "there should be a simpler way to do this." This Utilities package is my attempt to make those things as easy as I can and provide that "simpler way." As of June 24, 2016 that was a couple Artisan commands to make dealing with users locally just a little easier. This could be made a `dev` only package, but if someone has access to Artisan on your server, they can pretty much do what they want already.

## Installation

The usual:

`composer require ahuggins/utilities`

After that installs, add the following to your `config/app.php` file in the providers array:

> Note, with Laravel 5.5+, this should automatically be installed.

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
