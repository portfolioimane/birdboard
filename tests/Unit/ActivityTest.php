<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use PHPUnit\Framework\TestCase;
use App\Activity;
use App\Project;
use Tests\TestCase;


class ActivityTest extends TestCase
{
	use RefreshDatabase;
	function it_has_a_user(){
		 $user=$this->signIn();
         $project=ProjectFactory::ownedBy($user)->create();
         $this->assertEquals($user->id, $project->activity->first()->user->id);
	}
}

