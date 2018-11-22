<?php

use Faker\Generator as Faker;

$factory->define(App\Periodo::class, function (Faker $faker) {
    return [
        'periodo' => today()->year,
        'fechaInicio' => $faker->dateTimeBetween($startDate = '2018-01-01', $endDate = '2018-01-25', $timezone = null),
        'fechaFin' => $faker->dateTimeBetween($startDate = '2018-11-05', $endDate = '2018-11-20', $timezone = null)
    ];
});
