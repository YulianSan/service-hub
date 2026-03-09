<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize('viewAny', Project::class);

        return inertia('Project/Index', [
            'projects' => Project::where(
                'company_id',
                request()->user()->company_id
            )->with('company')->paginate(10)
        ]);
    }

    public function create()
    {
        $this->authorize('create', Project::class);

        return Inertia::render('Project/CreateEdit');
    }

    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create', Project::class);

        Project::create(
            [
                'company_id' => $request->user()->company_id,
            ] + $request->validated()
        );

        return redirect()->route('projects.index');
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return Inertia::render('Project/CreateEdit', [
            'project' => $project
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return redirect()->route('projects.index');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index');
    }
}
