<?php

namespace Tests\Feature;
use App\Task;
use Facades\Tests\Setup\ProjectTestFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class ProjectTasksTest extends TestCase
{
     use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_only_the_owner_of_a_project_may_add_tasks(){
        $this->signIn();
        $project=factory('App\Project')->create();
        $this->post($project->path() . '/tasks', ['body'=>'Test task'])
        ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body'=>'Test task']);
    }
    public function test_only_the_owner_of_a_project_may_update_a_task(){
        $this->signIn();
        $project=ProjectTestFactory::withTasks(1)->create();
        $task=$project->addTask('test task');
        $this->patch($project->tasks[0]->path(), ['body'=>'changed'])
        ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body'=>'changed']);
    }
    public function test_a_project_can_have_tasks()
    {
       //$this->withoutExceptionHandling();
       //$this->signIn();
       //$project=auth()->user()->projects()->create(factory('App\Project')->raw());
       $project=ProjectTestFactory::create();
       $this->actingAs($project->owner)->post($project->path() . '/tasks', ['body' =>'Test Task']);
       $this->get($project->path())->assertSee('Test Task');
    }
    public function test_a_task_can_be_updated(){
       $this->withoutExceptionHandling();
       $project=ProjectTestFactory::ownedBy($this->signIn())->withTasks(1)->create();
       //$this->signIn();
       //$project=auth()->user()->projects()->create(factory('App\Project')->raw());
       //$task=$project->addTask('test task');
       $this->patch($project->tasks[0]->path(), [
          'body'=>'changed'
       ]);
       $this->assertDatabaseHas('tasks', [
         'body'=>'changed'
       ]);
    }
    public function test_a_task_can_be_completed(){
       $this->withoutExceptionHandling();
       $project=ProjectTestFactory::ownedBy($this->signIn())->withTasks(1)->create();
       //$this->signIn();
       //$project=auth()->user()->projects()->create(factory('App\Project')->raw());
       //$task=$project->addTask('test task');
       $this->patch($project->tasks[0]->path(), [
          'body'=>'changed',
          'completed'=>true
       ]);
       $this->assertDatabaseHas('tasks', [
         'body'=>'changed',
         'completed'=>true
       ]);
    }
        public function test_a_task_can_be_marked_as_incomplete(){
       $this->withoutExceptionHandling();
       $project=ProjectTestFactory::ownedBy($this->signIn())->withTasks(1)->create();
       //$this->signIn();
       //$project=auth()->user()->projects()->create(factory('App\Project')->raw());
       //$task=$project->addTask('test task');
       $this->patch($project->tasks[0]->path(), [
          'body'=>'changed',
          'completed'=>true
       ]);
        $this->patch($project->tasks[0]->path(), [
          'body'=>'changed',
          'completed'=>false
       ]);
       $this->assertDatabaseHas('tasks', [
         'body'=>'changed',
         'completed'=>false
       ]);
    }
    public function test_a_task_requires_a_body(){
        //$this->signIn();
        //$project=auth()->user()->projects()->create(factory('App\Project')->raw());
        $project=ProjectTestFactory::create();
        $attributes=factory('App\Task')->raw(['body'=>'']);
        $this->actingAs($project->owner)->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
