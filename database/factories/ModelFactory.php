<?php

$factory->define(App\Team::class, function (Faker\Generator $faker) {
    return [
        'name' => $name = $faker->unique()->company,
        'slug' => str_slug($name),
    ];
});

$factory->define(App\Channel::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'team_id' => function () {
            return factory(App\Team::class)->create()->id;
        },
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->unique()->word,
        'email' => $faker->unique()->email,
        'password' => bcrypt('123456'),
        'team_id' => function () {
            return factory(App\Team::class)->create()->id;
        },
    ];
});
