<?php

use App\Models\Auth\User;
use App\Models\Project;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i < 20; $i++){
            factory(Ticket::class, rand(10, 20))->create([
                'created_by' => function() { return User::getRandomUser(); },
                'assigned_to' => function() {return User::getRandomUser(); },
                'project_id' => $this->getRandomProject(),
            ]);
        }

    }

    private function getRandomProject()
    {
        return Project::inRandomOrder()->first()->id;
    }
}
