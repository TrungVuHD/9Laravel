<?php

use Faker\Generator as Faker;

$factory->define(App\Point::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 1000),
        'post_id' => rand(1, 150)
    ];
});
