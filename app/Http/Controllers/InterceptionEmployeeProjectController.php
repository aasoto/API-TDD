<?php

namespace App\Http\Controllers;

use App\Http\Requests\InterptionEmployeeProject\StoreRequest;
use App\Models\Employee;
use App\Models\InterceptionEmployeeProject;
use App\Models\Project;
use Illuminate\Http\Request;

class InterceptionEmployeeProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        return response()->json(InterceptionEmployeeProject::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show_project_employee(Project $project)
    {
        $employees = InterceptionEmployeeProject::with('employee')
            -> with('project')
            -> where('project_id', $project->id)
            -> paginate(10);
        return response()->json($employees);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $project
     * @return \Illuminate\Http\Response
     */
    public function show_employee_project(Employee $employee)
    {
        $projects = InterceptionEmployeeProject::with('employee')
            -> with('project')
            -> where('employee_id', $employee->id)
            -> paginate(10);
        return response()->json($projects);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
