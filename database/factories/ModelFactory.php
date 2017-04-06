<?php

$factory->define(App\Team::class, function (Faker\Generator $faker) {
    return [
        'name' => $name = $faker->unique()->company,
        'slug' => str_slug($name),
    ];
});