<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Post::class, function (Faker $faker) {
    $cats = array_values(config('post.category'));
    return [
        'title' => $faker->sentence(8, true),
        'sapo' => $faker->sentence(20, true),
        'content' => $faker->paragraph(10, true),
        'user_id' => 1,
        'status' => 1,
        'publish_at' => Carbon::now(),
        'cat' => $cats[array_rand($cats)],
        'hot' => rand(0, 1),
    ];
});
