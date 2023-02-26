<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\support\Str;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_manage_project()
    {
        $project = Project::factory()->create();


        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path().'/edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');

        $this->post('/projects', $project->toArray())->assertRedirect('login');
    }

    
    /** @test */
    public function a_user_can_create_project()
    {


        $this->signin();

        $this->get('/projects/create')->assertStatus(200);

        $attributes = [

            'title' => $this->faker->sentence,

            'description' => $this->faker->sentence,

            'notes' => 'General notes here .',
        ];

        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());


        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_project()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::create();
        
        $this->actingAs($project->owner)->patch($project->path(), $attributes = [
            'title' => 'changed',
            'description' => 'changed',
            'notes' => 'changed',
        ])->assertRedirect($project->path());

        $this->get($project->path().'/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_projects_general_notes()
    {
        $project = ProjectFactory::create();
        
        $this->actingAs($project->owner)->patch($project->path(), $attributes = ['notes' => 'changed']);

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_view_thier_project()
    {

        // $this->signin();

        // $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->get($project->path())
            ->assertSee($project->title)
            ->assertSee(Str::limit($project->description, 100));

    }


    /** @test */
    public function an_auth_user_cannot_view_the_projects_of_other()
    {
        $this->signin();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_auth_user_cannot_update_the_projects_of_others()
    {
        $this->signin();

        $project = Project::factory()->create();

        $this->patch($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_project_require_a_title()
    {
        $this->signin();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_require_a_description()
    {
        $this->signin();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    

    
}
