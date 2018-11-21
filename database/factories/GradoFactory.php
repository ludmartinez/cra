<?php

use Faker\Generator as Faker;

$factory->define(App\Grado::class, function (Faker $faker) {
    return [
        'grado' => $faker->unique()->word(),
        'cupo' => $faker->numberBetween(10, 25),
    ];
});
