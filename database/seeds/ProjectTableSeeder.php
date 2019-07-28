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
        factory(Project::class, 100)->create([
            'owner'=> User::getRandomUser(),
            'created_by'=> User::getRandomUser(),
        ]);
    }
}
