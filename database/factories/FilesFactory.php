<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Files;
use Faker\Generator as Faker;

$factory->define(Files::class, function (Faker $faker) {
    return [
        'filename' => 'dummy-image.png',
        'knownas' => $faker->name,
        'description' => $faker->paragraph(),
        'size' => $faker->numberBetween(1000, 50000),
        'uploaded_by' => null,
        'ticket_id' => null,
        'project_id' => null,
    ];
});
