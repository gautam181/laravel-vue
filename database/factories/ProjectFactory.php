<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name'=> "Project By ".$faker->name,
        'description'=> $faker->paragraphs(),
        'start_date' => now(),
        'end_date'  => now(),
        'owner'=> null,
        'created_by'=> null
    ];
});
