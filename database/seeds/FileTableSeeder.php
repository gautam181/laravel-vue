<?php

use App\Models\Auth\User;
use App\Models\File;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class FileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i < 20; $i++){
            $ticket = $this->getRandomTicket();
            factory(File::class, rand(10, 20))->create([
                'uploaded_by' => function() { return User::getRandomUser(); },
                'project_id' => $ticket->project_id,
                'ticket_id' => $ticket->id,
            ]);
        }
    }

    private function getRandomTicket()
    {
        return Ticket::inRandomOrder()->first();
    }
}
