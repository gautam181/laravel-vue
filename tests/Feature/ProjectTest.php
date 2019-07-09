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
     * @test
     */
    public function viewProjectsList()
    {
        $this->actingAs(factory(User::class)->create(), 'api');
        $response = $this->json('GET', route('project.list'));
        $response->assertStatus(200);
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
        /*$this->actingAs(factory(User::class)->create(), 'api');

        $response = $this->json('PUT', route('project.update'),
            $this->data()
        );
        $this->assertCount(1, Project::all());
        $response->assertStatus(202);*/
    }

}
