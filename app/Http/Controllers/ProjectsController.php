<?php

namespace App\Http\Controllers;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProjectRequest;
class ProjectsController extends Controller
{
    public function index(){
        $projects=auth()->user()->accessibleProjects();
	    return view('projects.index', compact('projects'));
    }
    public function show(Project $project){
        $this->authorize('update',$project);
    	return view('projects.show', compact('project'));
    }
    public function create(){
        return view('projects.create');
    }
    public function store(){
        //$attributes['owner_id']=auth()->id();
        
        $project=auth()->user()->projects()->create($this->validateRequest());
        //dd($attributes);
        //Project::create($attributes);
        return redirect($project->path());
    }
    public function update(UpdateProjectRequest $form)
{    
    // $request->save();

    // return redirect($project->path());
    // return redirect($request->project()->path());
    return redirect($form->save()->path());
}
    public function destroy(Project $project){
        $this->authorize('update',$project);
        $project->delete();
        return redirect('/projects');
    }
    public function edit(Project $project){
       return view('projects.edit',compact('project'));
    }
    protected function validateRequest(){
        return request()->validate([
            'title'=>'sometimes|required', 
            'description'=>'sometimes|required',
            'notes'=>'nullable'
        ]);
    }
}
