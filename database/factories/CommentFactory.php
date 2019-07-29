<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'comment'=> $faker->paragraph(5),
        'project_id'=> null,
        'ticket_id'=> null,
        'start_date' => $faker->dateTimeBetween('+0 days', '+1 month'),
        'end_date'  => $faker->dateTimeBetween('+1 month', '+6 months'),
        'created_by'=> 1
    ];
});
