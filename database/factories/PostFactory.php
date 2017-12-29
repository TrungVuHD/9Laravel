<?php

use Faker\Generator as Faker;
use App\Http\Services\ImageService as Image;

$factory->define(App\Post::class, function (Faker $faker) {
    $title = $faker->sentence(10);
    $slug = str_slug($title);
    $image_dir = storage_path("app/public/" . App\Post::IMG_DIR);
    $image_categories = [ 'technics', 'city', 'nature', 'cats' ];
    $image = $faker->image($image_dir, $width = 1920, $height = 1080, $image_categories[rand(0, 3)]);
    $image_name = basename($image);

    Image::multipleSizes($image, Image::SIZES);

    return [
        'title' => $title,
        'image' => $image_name,
        'slug' => $slug,
        'user_id' => rand(1, 3),
        'gif' => false,
        'tall_image' => false,
        'cat_id' => rand(1, 10)
    ];
});
