<?php

use Faker\Generator as Faker;

$factory->define(App\Materia::class, function (Faker $faker) {
    return [
        'materia' => $faker->unique()->word(),
    ];
});
