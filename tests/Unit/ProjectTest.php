<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;


class ProjectTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_can_invite_a_user(){
        $project=factory('App\Project')->create();
        $project->invite($user = factory(\App\User::class)->create());
        $this->assertTrue($project->members->contains($user));
    }
    public function test_it_has_a_path()
    {
        $project=factory('App\Project')->create();
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }
    public function test_it_belongs_to_an_owner(){
        $project=factory('App\Project')->create();
        $this->assertInstanceOf('App\User', $project->owner);
    }
    public function test_it_can_add_a_task(){
        $project=factory('App\Project')->create();
        $task=$project->addTask('Test Task');
        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }
}
