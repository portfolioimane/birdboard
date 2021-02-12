<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectTestFactory;
use Tests\TestCase;
use App\User;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_project_can_invite_a_user()
    {
        $project=ProjectTestFactory::create();
        $project->invite($newUser=factory(User::class)->create());
        $this->signIn($newUser);
        $this->post(action('ProjectTasksController@store', $project), $task=['body'=>'Foo task']);
        $this->assertDatabaseHas('tasks', $task);
    }
}
