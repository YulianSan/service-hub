<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return inertia('Project/Index', [
            'projects' => Project::where(
                'company_id',
                request()->user()->company_id
            )->with('company')->paginate(15)
        ]);
    }

    public function create()
    {
        return Inertia::render('Project/CreateEdit');
    }

    public function store(StoreProjectRequest $request)
    {
        Project::create(
            [
                'company_id' => $request->user()->company_id,
            ] + $request->validated()
        );

        return redirect()->route('projects.index');
    }

    public function edit(Project $project)
    {
        return Inertia::render('Project/CreateEdit', [
            'project' => $project
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }
}
