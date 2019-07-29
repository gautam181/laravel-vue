<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'comment'=> $faker->paragraph(5),
        'project_id'=> null,
        'ticket_id'=> null,
        'created_by'=> 1
    ];
});
