<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Event::class, function (Faker\Generator $faker) {
    return [
        'name'        => $faker->sentence(3),
        'description' => $faker->paragraph(),
        'venue'       => $faker->company,
        'start_date'  => $faker->dateTimeBetween('now', '+1 month')
    ];
});
