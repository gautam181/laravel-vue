<?php

use App\Models\Auth\User;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i< 20; $i++){
            factory(Project::class, rand(3, 10))->create([
                'owner'=> function() { return User::getRandomUser(); },
                'created_by'=> function() { return User::getRandomUser(); },
            ]);
        }

    }
}
