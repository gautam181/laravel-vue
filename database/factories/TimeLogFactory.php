<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TimeLog;
use Faker\Generator as Faker;

$factory->define(TimeLog::class, function (Faker $faker) {
    return [
        'description' => $faker->paragraph(),
        'date' => $faker->dateTimeBetween('+0 days', '+1 month'),
        'time' => $faker->time(),
        'hours' => $faker->numberBetween(0, 10),
        'minutes' => $faker->numberBetween(0, 59),
        'created_by' => null,
        'user_id' => null,
        'ticket_id' => null,
        'project_id' => null,
    ];
});
