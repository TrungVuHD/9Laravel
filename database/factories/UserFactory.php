<?php

use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    $name = $faker->name;
    $username = str_slug($name) . str_random(10);

    return [
        'name' => $faker->name,
        'username' => $username,
        'email' => $faker->unique()->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});
