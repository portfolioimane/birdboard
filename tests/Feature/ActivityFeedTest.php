<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectTestFactory;
use Tests\TestCase;
use App\Task;
use App\Activity;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
   public function test_creating_a_project_records_activity(){
    $project=ProjectTestFactory::create();
    $this->assertCount(1, $project->activity);
       tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_project', $activity->description);
            $this->assertNull($activity->changes);
        });
   }
   public function test_updating_a_project_records_activity(){
    $project=ProjectTestFactory::create();
    $originalTitle=$project->title;
    $project->update(['title'=>'Changed']);
    $this->assertCount(2, $project->activity);
       tap($project->activity->last(), function ($activity) use ($originalTitle){
           $this->assertEquals('updated_project',$activity->description);
           $expected=[
             'before'=>['title'=>$originalTitle],
             'after'=>['title'=>'Changed']
           ];
           $this->assertEquals($expected, $activity->changes);
        });
   }
   public function test_creating_a_new_task_records_activity(){
        $project = ProjectTestFactory::create();

        $project->addTask('Some task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Some task', $activity->subject->body);
        });
    }
    public function test_completing_a_new_task_records_activity(){
    $project=ProjectTestFactory::withTasks(1)->create();
    $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
        'body'=>'foobar',
        'completed'=>true
    ]);
    $this->assertCount(3, $project->activity);
     tap($project->activity->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
   }
     
   public function test_incompleting_a_new_task_records_activity(){
    $project=ProjectTestFactory::withTasks(1)->create();
    $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
        'body'=>'foobar',
        'completed'=>true
    ]);
    $this->assertCount(3, $project->activity);
    $this->patch($project->tasks[0]->path(), [
        'body'=>'foobar',
        'completed'=>false
    ]);
     //dd($project->fresh()->activity->toArray());
     $this->assertCount(4, $project->fresh()->activity);
     $this->assertEquals('incompleted_task', $project->fresh()->activity->last()->description);
    //$this->assertEquals('completed_task',$project->Activity->last()->description);
   }
   function test_deleting_task(){
        $project=ProjectTestFactory::withTasks(1)->create();
        $project->tasks[0]->delete();
        $this->assertCount(3, $project->activity);
   }


}
