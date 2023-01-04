<?php

use App\Http\Controllers\ContractorCompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InterceptionEmployeeProjectController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** RUTAS PROTEGIDAS CON LARAVEL SANCTUM */
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('employee/all', [EmployeeController::class, 'all']);
    Route::get('contractor-company/all', [ContractorCompanyController::class, 'all']);
    Route::get('projects/all', [ProjectController::class, 'all']);
});

Route::resource('employee', EmployeeController::class)->except(['create', 'edit']);
Route::resource('contractor-company', ContractorCompanyController::class)->except(['create', 'edit']);
Route::resource('projects', ProjectController::class)->except(['create', 'edit']);

Route::post('assing-employee-project', [InterceptionEmployeeProjectController::class, 'store'])->name('assing-employee-project');
Route::get('project-employee/{project}', [InterceptionEmployeeProjectController::class, 'show_project_employee'])->name('project-employee');
Route::get('employee-project/{employee}', [InterceptionEmployeeProjectController::class, 'show_employee_project'])->name('employee-project');

