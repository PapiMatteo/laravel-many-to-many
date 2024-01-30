<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $technologies = Technology::all();
        $types = Type::all();
        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $form_data = $request->validated();

        $new_project = new Project();
        $new_project->fill($form_data);

        if($request->hasFile('cover_image')) {
            $path = Storage::put('project_images', $request->cover_image);
            $new_project->cover_image = $path;
        }

        $new_project->save();

        if($request->has('technologies')){
            $new_project->technologies()->attach($request->technologies);
        }

        return redirect()->route('admin.projects.show', ['project' => $new_project->slug]);
    }

    /**
     * Display the specified resource.
     */
                    //  Dependence Injection
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();
        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $form_data = $request->validated();

        if($request->hasFile('cover_image')) {
            if($project->cover_image) {
                Storage::delete($project->cover_image);
            }

            $path = Storage::put('project_images', $request->cover_image);
            $form_data['cover_image'] = $path;
        }

        $project->update($form_data);

        if($request->has('technologies')){
            $project->technologies()->sync($request->technologies);
        }else {
            $project->technologies()->sync([]);
        }

        return redirect()->route('admin.projects.show', ['project' => $project->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('message', "$project->title e' stato eliminato con successo");
    }
}
