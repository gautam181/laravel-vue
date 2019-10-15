<?php

namespace Tests\Feature;

use App\Models\Auth\User;
use App\Models\Project;
use App\Models\Ticket;
use App\Models\TimeLog;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    private function data(){
        return [
            'name' => 'Test project',
            'description' => 'Test Description',
            'start_date' => '',
            'end_date' => '',
            'progress' => 0,
            'owner' => 1
        ];
    }

    /**
     * @param int $count
     * @param array $data
     *
     * @return mixed
     */
    private function addProjects($count=3, $data= []){
        return factory(Project::class, $count)->create($data);
    }
    /**
     * test all routes for project to make sure they are projected for un-authenticated user access
     * @test
     */
    public function verifyAuthLogin(){
        $this->get(route('project.list'))->assertRedirect('login');
        $this->post(route('project.store'))->assertRedirect('login');
        $this->get(route('project.show', 1))->assertRedirect('login');
        $this->put(route('project.update', 1))->assertRedirect('login');
        $this->delete(route('project.destroy', 1))->assertRedirect('login');
    }


    /**
     * @test
     */
    public function createProjects()
    {
        $this->getActingAsUser();

        $response = $this->json('POST', route('project.store'), $this->data() );
        $this->assertCount(1, Project::all());
        $response->assertStatus(201);
    }

    /**
     * project list with output structure test
     *
     * @test
     */
    public function viewProjectsList()
    {
        $this->getActingAsUser();
        $this->addProjects(2, ['owner'=>1]);
        $response = $this->json('GET', route('project.list'));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "current_page",
            "total",
            "data" => [
                "*" => [
                    "id",
                    "name",
                    "description",
                    "start_date",
                    "end_date",
                    "progress",
                    "owner",
                    "created_by"
                ]
            ]
        ]);
    }

    /**
     * creating the project with owner
     *
     * @test
     */
    public function viewProjectsWithOwnerList()
    {
        $this->getActingAsUser();
        $this->addProjects(2, ['owner'=> null]);
        $response = $this->json('GET', route('project.list'));
        $response->assertStatus(200);
        $response->assertJsonFragment(["owner" => null]);
    }



    /**
     * @test
     */
    public function nameIsRequiredForProject()
    {
        $this->getActingAsUser();

        $response = $this->json('POST', route('project.store'),
            array_merge($this->data(), ['name'=>''])
            );

        $response->assertJsonValidationErrors('name');
        $this->assertCount(0, Project::all());
        $response->assertStatus(422);
    }

    /**
    *@test
    */
    public function ownerIsValidUser(){
        $this->getActingAsUser();

        $response = $this->json('POST', route('project.store'),
            array_merge($this->data(), ['owner'=>'1'])
        );


        $this->assertCount(1, Project::all());
        $response->assertStatus(201);
        $response->assertJson(['message' => "Project created successfully"]);
    }

    /**
     *@test
     */
    public function ownerIsInValidUser(){
        $this->getActingAsUser();

        $response = $this->json('POST', route('project.store'),
            array_merge($this->data(), ['owner'=>'524'])
        );


        $this->assertCount(0, Project::all());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('owner');
    }

    /**
     * @test
     */
    public function descriptionIsRequiredForProject()
    {
        $this->getActingAsUser();

        $response = $this->json('POST', route('project.store'),
            array_merge($this->data(), ['description'=>''])
        );

        $response->assertJsonValidationErrors('description');
        $this->assertCount(0, Project::all());
        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function updateProject()
    {
        $this->getActingAsUser();
        $projects = $this->addProjects(1);
        $project = $projects[0]->toArray();
        $data = [
            'name' => 'edit project',
            'description' => 'Test Description',
            'start_date' => null,
            'progress' => 0,
            'end_date' => null,
            'owner' => 1
        ];
        $response = $this->json('PUT', route('project.update', $project['id']),
            $data
        );
        $this->assertCount(1, Project::all());
        $response->assertStatus(202);
        $response->assertJson(['message' => "Project updated successfully"]);
        $response->assertJson(['data' => $data]);
    }

    /**
     * @test
     */
    public function deleteProject()
    {
        $this->getActingAsUser();
        $projects = $this->addProjects(1);
        $project = $projects[0]->toArray();
        $response = $this->json('DELETE', route('project.destroy', $project['id']));
        $this->assertCount(0, Project::all());
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function viewProject()
    {
        $this->getActingAsUser();
        $projects = $this->addProjects(1);
        $project = $projects[0]->toArray();
        $response = $this->json('GET', route('project.show', $project['id']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
                    "id",
                    "name",
                    "description",
                    "start_date",
                    "end_date",
                    "owner" => [],
                    "created_by" => []
        ]);
    }

    /**
     * @test
     */
    public function getProjectTickets()
    {
        $this->getActingAsUser();
        $projects = $this->addProjects(1);
        $project = $projects[0]->toArray();
        factory(Ticket::class, 10)->create(['project_id' => $project['id'], 'created_by'=> 1, 'assigned_to'=>1]);
        $response = $this->json('GET', route('project.ticket', $project['id']));
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
                    "assigned_to" => ["id", "name"],
                    "project" => ["id", "name"],
                    "created_by"
                ]
            ]
        ]);


    }

    /**
     * @test
     */
    public function getProjectTime()
    {
        $this->getActingAsUser();
        $projects = $this->addProjects(1);
        $project = $projects[0]->toArray();
        factory(Ticket::class, 1)->create(['project_id' => $project['id'], 'created_by'=> 1, 'assigned_to'=>1]);
        factory(TimeLog::class, 20)->create(['project_id' => $project['id'], 'ticket_id'=> 1, 'created_by'=>1, 'user_id'=>1]);
        $response = $this->json('GET', route('project.time', $project['id']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "current_page",
            "total",
            "data" => [
                "*" => [
                    "id",
                    "project_id",
                    "date",
                    "time",
                    "description",
                    "hours",
                    "minutes",
                    "project_name",
                    "project_status",
                    "ticket_id",
                    "ticket_name",
                    "created_by",
                    "user_id",
                    "user_name",
                    "user_email",
                    "updated_at",
                    "created_at",
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function getProjectTimeSummary()
    {
        $this->getActingAsUser();
        $projects = $this->addProjects(1);
        $project = $projects[0]->toArray();
        factory(Ticket::class, 1)->create(['project_id' => $project['id'], 'created_by'=> 1, 'assigned_to'=>1]);
        factory(TimeLog::class, 20)->create(['project_id' => $project['id'], 'ticket_id'=> 1, 'created_by'=>1, 'user_id'=>1]);
        $response = $this->json('GET', route('project.time.summary', $project['id']));
        $response->assertStatus(200);
        $response->assertJsonStructure([
            "data" => [
                "loggedHours",
                "loggedMinutes",
                "estimatedHours",
                "estimatedMinutes"
            ]
        ]);
    }

    /**
     * @test
     */
    public function markProjectAsCompleted()
    {
        //todo: mark project as completed
        $this->getActingAsUser();
        $this->assertSame('todo', 'todo');
    }

    /**
     * @test
     */
    public function projectSummary()
    {
        //todo: get project summary
        $this->getActingAsUser();
        $this->assertSame('todo', 'todo');
    }

    private function getActingAsUser()
    {
        $this->actingAs(factory(User::class)->create(), 'api');
    }
}
