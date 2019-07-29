<?php

use App\Models\Comment;
use App\Models\Auth\User;
use App\Models\Ticket;
use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
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
            factory(Comment::class, rand(10, 20))->create([
                'created_by' => function() { return User::getRandomUser(); } ,
                'project_id' => $ticket->project_id,
                'ticket_id' => $ticket->id,
            ]);
        }
    }

    private function getRandomTicket()
    {
        return Ticket::inRandomOrder()->select('id', 'project_id')->first();
    }
}
