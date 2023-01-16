<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee\ImageRequest;
use App\Http\Requests\Employee\StoreRequest;
use App\Http\Requests\Employee\UpdateRequest;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Employee::paginate(10));
    }

    /**
     * Display a listing of the resource without pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        return response()->json(Employee::get());
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
        /**************** MOVER IMAGEN ****************/
        if (isset($data['profile_photo'])) {
            if (!is_string($data['profile_photo'])) {
                $data['profile_photo'] = $filename = time().'.'.$data['profile_photo']->extension();
                $request->profile_photo->move(public_path('profile-photos'), $filename);
            }
        }
        /*********************************************/
        Employee::create($data);
        $response = json_decode('{"status":"saved"}');
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        $result = Employee::find($employee->id);
        return response()->json($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Employee $employee)
    {
        $data = $request->validated();

        /**************** MOVER IMAGEN ****************/
        if (isset($data['profile_photo'])) {
            if ($employee->profile_photo && ($data['escenario'] == 'testing')) {
                unlink('storage/app/public/profile-photos/'.$employee->profile_photo);
            }

            if (!is_string($data['profile_photo']) && ($data['escenario'] == 'testing')) {
                $data['profile_photo'] = $filename = time().'.'.$data['profile_photo']->extension();
                $request->profile_photo->move(public_path('profile-photos'), $filename);
            }
        }
        /*********************************************/
        $employee->update($data);
        return response()->json($data);
    }

    /**
     *
     */
    public function update_profile_photo (ImageRequest $request) {
        $data = $request->validated();
        $employee = Employee::where('id', $data['id'])->first();
        /**************** MOVER IMAGEN ****************/
        if (isset($data['profile_photo'])) {
            if ($employee->profile_photo) {
                unlink('profile-photos/'.$employee->profile_photo);
            }
            if (!is_string($data['profile_photo'])) {
                $data['profile_photo'] = $filename = time().'.'.$data['profile_photo']->extension();
                $request->profile_photo->move(public_path('profile-photos'), $filename);
            }
        }
        if (isset($data['profile_photo'])) {
            $response = $data['profile_photo'];
        } else {
            $response = $employee->profile_photo;
        }
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if ($employee->profile_photo) {
            unlink('profile-photos/'.$employee->profile_photo);
        }

        $employee->delete();
        $response = json_decode('{"status":"delete"}');
        return response()->json($response);
    }
}
