<?php

use App\Account;
use App\User;
use Faker\Generator;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Account::class, function ($faker) {
    return [
        'name' => 'Zotti'
    ];
});

$factory->define(User::class, function ($faker) {
    static $password;
    return [
        'account_id' => Account::all()->random()->id,
        'name' => 'Administrador',
        'email' => 'admin@zotti.com.br',
        'password' => $password ?: $password = bcrypt('12qwaszx'),
        'remember_token' => str_random(10),
    ];
});

