<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectTestFactory;
use Tests\TestCase;
use Illuminate\Support\Str;
use App\Project;
class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_only_authentificated_users_can_create_projects(){
        // $this->signIn();
       // $this->withoutExceptionHandling();
        $attributes=factory('App\Project')->raw();
        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    public function test_guests_cannot_manage_projects(){
      $project=factory('App\Project')->create();
      $this->get('/projects/create')->assertRedirect('login');
      $this->post('/projects', $project->toArray())->assertRedirect('login');
      $this->get('/projects')->assertRedirect('login');
      $this->get($project->path())->assertRedirect('login');
    }
    public function test_a_user_can_create_project()
    {
       $this->withoutExceptionHandling();
       $this->signIn();
       $this->get('/projects/create')->assertStatus(200);
      $attributes = [
        'title' => $this->faker->sentence,
        'description' => $this->faker->sentence,
        'notes'=>'General notes here.'
       // 'owner_id' => factory(User::class)->create()->id    
      ];
       $response=$this->post('/projects', $attributes);
       $project=Project::where($attributes)->first();
       $response->assertRedirect($project->path());
       $this->get($project->path())->assertSee($attributes['title'])->assertSee($attributes['description'])->assertSee($attributes['notes']);
    }
    function test_a_user_can_delete_a_project(){
        $this->withoutExceptionHandling();
        $project=ProjectTestFactory::create();
        $this->actingAs($project->owner)
        ->delete($project->path())
        ->assertRedirect('/projects');
        $this->assertDatabaseMissing('projects', $project->only('id'));
    }
    function test_a_user_can_see_all_projects_they_have_been_invited_to_their_dashboard(){
      $this->withoutExceptionHandling();
      $project=tap(ProjectTestFactory::create())->invite($this->signIn());
      $this->get('/projects')->assertSee($project->title);
    }
    function test_guests_cannot_delete_projects(){
      $project=ProjectTestFactory::create();
      $this->delete($project->path())->assertRedirect('/login');
      $this->signIn();
      $this->delete($project->path())->assertStatus(403);
    }
    function test_a_user_can_update_a_project(){
       // $this->withoutExceptionHandling();
       // $this->signIn();
       // $project=factory('App\Project')->create(['owner_id'=>auth()->id()]);
      $project=ProjectTestFactory::create();
        $this->actingAs($project->owner)->patch($project->path(), $attributes=['title'=>'changed','description'=> 'changed', 'notes'=>'Changed'
        ])->assertRedirect($project->path());
        $this->get($project->path(). '/edit')->assertOk();
        $this->assertDatabaseHas('projects', $attributes);
    }
        function test_a_user_can_update_a_project_general_notes(){
       // $this->withoutExceptionHandling();
       // $this->signIn();
       // $project=factory('App\Project')->create(['owner_id'=>auth()->id()]);
      $project=ProjectTestFactory::create();
        $this->actingAs($project->owner)->patch($project->path(), $attributes=[ 'notes'=>'Changed'
        ]);
        $this->get($project->path(). '/edit')->assertOk();
        $this->assertDatabaseHas('projects', $attributes);
    }
         public function test_a_user_can_view_a_project() {
            //$this->be(factory('App\User')->create());
            //$this->signIn();
            //$this->withoutExceptionHandling();
            //$project = factory('App\Project')->create(
              //  [
             //       'owner_id' => auth()->id(),
                //    'title'     => $this->faker->sentence(4),
                //    'description'  => $this->faker->sentence(4),
             //   ]);
            $project=ProjectTestFactory::create();
            $this->actingAs($project->owner)->get($project->path())
                ->assertSee($project->title)
                ->assertSee(Str::limit($project->description));
        }
        public function test_an_authenticated_user_cannot_view_the_projects_of_others(){
          $this->signIn();
          $project=factory('App\Project')->create();
          $this->get($project->path())->assertStatus(403);
        }
         public function test_an_authenticated_user_cannot_update_the_projects_of_others(){
          $this->signIn();
          $project=factory('App\Project')->create();
          $this->patch($project->path())->assertStatus(403);
        }
    public function test_a_project_requires_a_title(){
         $this->signIn();
        $attributes=factory('App\Project')->raw(['title'=>'']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }
    public function test_a_project_requires_a_description(){
         $this->signIn();
        $attributes=factory('App\Project')->raw(['description'=>'']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
