<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    $title = $faker->unique()->word;
    $title = ucfirst($title);
    $slug = str_slug($title);

    return [
        'title' => $title,
        'description' => $faker->paragraph,
        'published' => true,
        'show_in_menu' => true,
        'slug' => $slug
    ];
});
