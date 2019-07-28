<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'title'=> $faker->sentence(15),
        'description' => $faker->paragraph(),
        'start_date' => now(),
        'end_date' => now(),
        'created_by' => null,
        'assigned_to' => null,
        'project_id' => null,
    ];
});
