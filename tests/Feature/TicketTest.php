<?php

namespace Tests\Feature;

use App\Models\Auth\User;
use App\Models\Project;
use App\Models\Ticket;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @return array
     */
    private function data(){
        return [
            'title' => 'Test Ticket',
            'description' => 'Test Description',
            'start_date' => Carbon::now()->format('y-m-d H:i:s'),
            'end_date' => Carbon::now()->addDays(15)->format('y-m-d H:i:s'),
            'project_id' => null,
            'assigned_to' => null
        ];
    }

    private function getProject()
    {
       return factory(Project::class)->create();
    }

    /**
     * @param int $count
     * @param array $data
     *
     * @return mixed
     */
    private function addTickets($count=3, $data= []){
        return factory(Ticket::class, $count)->create($data);
    }
    /**
     * test all routes for Ticket to make sure they are Ticketed for un-authenticated user access
     * @test
     */
    public function verifyAuthLogin(){
        $this->get(route('ticket.list'))->assertRedirect('login');
        $this->post(route('ticket.store'))->assertRedirect('login');
        $this->get(route('ticket.show', 1))->assertRedirect('login');
        $this->put(route('ticket.update', 1))->assertRedirect('login');
        $this->delete(route('ticket.destroy', 1))->assertRedirect('login');
    }


    /**
     * @test
     */
    public function createTickets()
    {
        $this->actingAs(factory(User::class)->create(), 'api');
        $project = $this->getProject();
        $data = array_merge($this->data(), ['project_id'=> $project->id, 'assigned_to'=> 1]);
        $response = $this->json('POST', route('ticket.store'),$data );
        $this->assertCount(1, Ticket::all());
        $response->assertStatus(201);
    }

    /**
     * Ticket list with output structure test
     *
     * @test
     */
    public function viewTicketsList()
    {
        $this->actingAs(factory(User::class)->create(), 'api');
        $project = $this->getProject();
        $this->addTickets(10, ['assigned_to'=>1, 'project_id'=> $project->id, 'created_by'=> 1]);
        $response = $this->json('GET', route('ticket.list'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "current_page",
            "total",
            "data" => [
                "*" => [
                    "id",
                    "title",
                    "description",
                    "start_date",
                    "end_date",
                    "assigned_to" => ["name"],
                    "project" => ["name"],
                    "created_by" => ["name"]
                ]
            ]
        ]);
    }

    /**
     * creating the Ticket with owner
     *
     * @test
     */
    public function viewTicketsListWithoutProjectAndAssignedTo()
    {
        $this->actingAs(factory(User::class)->create(), 'api');
        $this->addTickets(2, ['assigned_to'=> null, 'project_id'=> null, 'created_by'=> 1]);
        $response = $this->json('GET', route('ticket.list'));
        $response->assertStatus(200);
        $response->assertJsonFragment(["assigned_to" => null]);
        $response->assertJsonFragment(["project" => null]);
    }



    /**
     * @test
     */
    public function titleIsequiredForTicket()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $response = $this->json('POST', route('ticket.store'),
            array_merge($this->data(), ['title'=>''])
        );

        $response->assertJsonValidationErrors('title');
        $this->assertCount(0, Ticket::all());
        $response->assertStatus(422);
    }

    /**
     *@test
     */
    public function assignedToIsValidUser(){
        $this->actingAs(factory(User::class)->create(), 'api');

        $response = $this->json('POST', route('ticket.store'),
            array_merge($this->data(), ['assigned_to'=>'1'])
        );


        $this->assertCount(1, Ticket::all());
        $response->assertStatus(201);
        $response->assertJson(['message' => "Ticket created successfully"]);
    }

    /**
     *@test
     */
    public function assignedToIsInValidUser(){
        $this->actingAs(factory(User::class)->create(), 'api');

        $response = $this->json('POST', route('ticket.store'),
            array_merge($this->data(), ['assigned_to'=>'524'])
        );


        $this->assertCount(0, Ticket::all());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('assigned_to');
    }

    /**
     * @test
     */
    public function createTicketWithValidProject()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $response = $this->json('POST', route('ticket.store'),
            array_merge($this->data(), ['created_by'=>1, 'project_id'=> $this->getProject()->id])
        );

        $this->assertCount(1, Ticket::all());
        $response->assertStatus(201);
        $response->assertJson(['message' => "Ticket created successfully"]);
    }

    /**
     * @test
     */
    public function createTicketWithInvalidProject()
    {
        $this->actingAs(factory(User::class)->create(), 'api');

        $response = $this->json('POST', route('ticket.store'),
            array_merge($this->data(), ['created_by'=>1, 'project_id'=> 1231])
        );

        $this->assertCount(0, Ticket::all());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('project_id');
    }

    /**
     * @test
     */
    public function updateTicket()
    {
        $this->actingAs(factory(User::class)->create(), 'api');
        $Tickets = $this->addTickets(1, ['created_by'=> 1]);
        $Ticket = $Tickets[0]->toArray();
        $data = [
            'title' => 'edit Ticket',
            'description' => 'Test Description',
            'start_date' => null,
            'end_date' => null,
            'assigned_to' => 1
        ];
        $response = $this->json('PUT', route('ticket.update', $Ticket['id']),
            $data
        );
        $this->assertCount(1, Ticket::all());
        $response->assertStatus(202);
        $response->assertJson(['message' => "Ticket updated successfully"]);
        $response->assertJson(['data' => $data]);
    }

    /**
     * @test
     */
    public function deleteTicket()
    {
        $this->actingAs(factory(User::class)->create(), 'api');
        $Tickets = $this->addTickets(1, ['created_by'=> 1]);
        $Ticket = $Tickets[0]->toArray();
        $response = $this->json('DELETE', route('ticket.destroy', $Ticket['id']));
        $this->assertCount(0, Ticket::all());
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function viewTicket()
    {
        $this->actingAs(factory(User::class)->create(), 'api');
        $Tickets = $this->addTickets(1, ['created_by'=> 1, 'assigned_to'=> 1, 'project_id'=> $this->getProject()->id]);
        $Ticket = $Tickets[0]->toArray();
        $response = $this->json('GET', route('ticket.show', $Ticket['id']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "id",
            "title",
            "description",
            "start_date",
            "end_date",
            "assigned_to" => [],
            'project' => [],
            "created_by" => []
        ]);
    }
}
