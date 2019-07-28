<?php

use App\Models\Auth\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create(['email'=>'abdul@webequator.com']);
        factory(User::class, 30)->create();
    }
}
