<?php

namespace App\Http\Controllers;

use App\Http\Requests\Projects\StoreRequest;
use App\Http\Requests\Projects\UpdateRequest;
use App\Models\ContractorCompany;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::with('contractor_company')->paginate(10);
        return response()->json($projects);
    }

    /**
     * Display a listing of the resource without pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(Project::with('contractor_company')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        return response()->json(Project::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $result = Project::find($project->id);
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Project $project)
    {
        $data = $request->validated();
        $project->update($data);
        return response()->json($project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json('deleted');
    }
}
