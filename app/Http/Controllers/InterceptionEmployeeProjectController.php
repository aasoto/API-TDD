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
     * @param  $ids array ['employee_id', 'project_id']
     * @return true || false
     */
    public function is_assigned($ids)
    {
        $ids = json_decode($ids);
        $count = InterceptionEmployeeProject::where('employee_id', $ids[0])
        -> where('project_id', $ids[1])
        -> count();

        if ($count == 0) {
            return false;
        } else {
            return true;
        }

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
     * @param  \App\Models\InterceptionEmployeeProject  $interception
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = InterceptionEmployeeProject::where('employee_id', $id)->delete();

        if ($result) {
            $response = json_decode('{"status":"deleted"}');
        } else {
            $response = json_decode('{"status":"undeleted"}');
        }

        return response()->json($response);
    }
}
