<?php

namespace Tests\Feature;

use App\Models\Auth\User;
use App\Models\Project;
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
            'start_date' => null,
            'end_date' => null,
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
        $this->actingAs(factory(User::class)->create(), 'api');

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
        $this->actingAs(factory(User::class)->create(), 'api');
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
        $this->actingAs(factory(User::class)->create(), 'api');
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
        $this->actingAs(factory(User::class)->create(), 'api');

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
        $this->actingAs(factory(User::class)->create(), 'api');

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
        $this->actingAs(factory(User::class)->create(), 'api');

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
        $this->actingAs(factory(User::class)->create(), 'api');

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
        $this->actingAs(factory(User::class)->create(), 'api');
        $projects = $this->addProjects(1);
        $project = $projects[0]->toArray();
        $data = [
            'name' => 'edit project',
            'description' => 'Test Description',
            'start_date' => null,
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
        $this->actingAs(factory(User::class)->create(), 'api');
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
        $this->actingAs(factory(User::class)->create(), 'api');
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

}
