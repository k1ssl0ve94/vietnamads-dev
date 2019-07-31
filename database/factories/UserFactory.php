<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => \Hash::make('123123'),
        'remember_token' => str_random(10),
        'status' => config('user.status.active'),
        'group' => config('user.group.frontend'),
        'phone' => $faker->phoneNumber,
    ];
});
