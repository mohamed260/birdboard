<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }
    
    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $attributes = request()->validate([

        'title' => 'required',

        'description' => 'required',

        'notes' => 'min:3',
        
        ]);


        $project = auth()->user()->projects()->create($attributes);


        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $form)
    {
        return redirect($form->save()->path());
    }

}
