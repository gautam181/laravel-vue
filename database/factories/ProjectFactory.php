<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name'=> $faker->company,
        'description'=> $faker->paragraph(),
        'start_date' => now(),
        'end_date'  => now(),
        'owner'=> 1,
        'created_by'=> 1
    ];
});
