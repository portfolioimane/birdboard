<?php

namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Collection;
use Facades\Tests\Setup\ProjectTestFactory;
//use PHPUnit\Framework\TestCase;
use App\Project;
use App\User;

class UserTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_user_has_projects()
    {
    	
    	$user=factory('App\User')->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }
    function test_a_user_has_accessible_projects(){
        $john=$this->signIn();
        ProjectTestFactory::ownedBy($john)->create();
        $this->assertCount(1, $john->accessibleProjects());
        $sally=factory(User::class)->create();
        $nick=factory(User::class)->create();
        $project=tap(ProjectTestFactory::ownedBy($sally)->create())->invite($nick);
        $this->assertCount(1, $john->accessibleProjects());
        $sallyProject->invite($john);
        $this->assertCount(2, $john->accessibleProjects());
    }
}
