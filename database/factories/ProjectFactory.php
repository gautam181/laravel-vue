<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name'=> $faker->company,
        'description'=> $faker->paragraph(),
        'start_date' => $faker->dateTimeBetween('+0 days', '+1 month'),
        'end_date'  => $faker->dateTimeBetween('+1 month', '+6 months'),
        'owner'=> 1,
        'progress'=> $faker->numberBetween(0, 100),
        'status'=> $faker->boolean,
        'created_by'=> 1
    ];
});
