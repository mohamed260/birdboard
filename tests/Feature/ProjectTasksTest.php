<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_have_tasks()
    {

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    /** @test */
    public function a_task_can_be_updated()
    {   
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(),[
            'body' => 'changed',
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
        ]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {   
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(),[
            'body' => 'changed',
            'completed' => true,
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
            'completed' => true,
        ]);
    }

    /** @test */
    public function a_task_can_be_marked_as_incompleted()
    {   
        $this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(),[
            'body' => 'changed',
            'completed' => true,
        ]);

        $this->patch($project->tasks[0]->path(),[
            'body' => 'changed',
            'completed' => false,
        ]);

        $this->assertDatabaseHas('tasks',[
            'body' => 'changed',
            'completed' => false,
        ]);
    }

    /** @test */
    public function only_owner_of_theadding_project_may_add_tasks()
    {
        $this->signin();

        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks',['body' => 'Test task']);
    }

    /** @test */
    public function only_owner_of_the_adding_project_may_update_a_task()
    {
        $this->signin();

        $project = ProjectFactory::withTasks(1)->create();


        $this->patch($project->tasks[0]->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks',['body' => 'changed']);
    }

    /** @test */
    public function a_task_require_a_body()
    {

       

        $project = ProjectFactory::create();


        $attributes = Task::factory()->raw(['body' => '']);

        $this->actingAs($project->owner)->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
