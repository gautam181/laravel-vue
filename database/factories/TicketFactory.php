<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Ticket;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'title'=> $faker->sentence(15),
        'description' => $faker->paragraph(),
        'start_date' => $faker->dateTimeBetween('+0 days', '+1 month'),
        'end_date'  => $faker->dateTimeBetween('+1 month', '+6 months'),
        'created_by' => null,
        'assigned_to' => null,
        'project_id' => null,
    ];
});
