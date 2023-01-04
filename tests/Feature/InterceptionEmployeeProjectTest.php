<?php

namespace Tests\Feature;

use App\Models\Employee;
use App\Models\InterceptionEmployeeProject;
use App\Models\Project;
use App\Traits\CreateRecords;
use App\Traits\InterceptionTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class InterceptionEmployeeProjectTest extends TestCase
{
    use CreateRecords;
    use InterceptionTrait;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function assign_employee_project ()
    {
        $employee = $this->create_and_get_employees(3);
        $project = $this->create_and_get_projects(3);

        $not_approved = $this->intercepted_employee_project($project, $employee);

        if (!$not_approved) {
            $response = $this->postJson( route('assing-employee-project'), [
                'employee_id' => $employee->id,
                'project_id' => $project->id
            ]);

            $response -> assertStatus(200)
                -> assertJson(fn (AssertableJson $json) =>
                    $json   ->has('id')
                        -> hasAny(
                            'employee_id',
                            'project_id',
                            'updated_at',
                            'created_at'
                        )
            );
        }

    }

    /** @test */
    public function list_interceptions_by_project ()
    {
        $project = $this->create_and_get_projects(3);

        $result = $this->project_has_employees($project);

        if ($result) {
            $response = $this->getJson(route('project-employee', $project));

            $response -> assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'employee_id',
                        'project_id',
                        'employee' => [
                            'id',
                            'cc',
                            'first_name',
                            'second_name',
                            'gender',
                            'birthdate',
                            'profile_photo'
                        ],
                        'project' => [
                            'id',
                            'title',
                            'description',
                            'start_execution',
                            'end_execution',
                            'contractor_company_id'
                        ]
                    ]
                ]
            ]);
        }
    }

    /** @test */
    public function list_interceptions_by_employee ()
    {
        $employee = $this->create_and_get_employees(3);

        $result = $this->employee_has_projects($employee);

        if ($result) {
            $response = $this->getJson(route('employee-project', $employee));

            $response -> assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    '*' => [
                        'id',
                        'employee_id',
                        'project_id',
                        'employee' => [
                            'id',
                            'cc',
                            'first_name',
                            'second_name',
                            'gender',
                            'birthdate',
                            'profile_photo'
                        ],
                        'project' => [
                            'id',
                            'title',
                            'description',
                            'start_execution',
                            'end_execution',
                            'contractor_company_id'
                        ]
                    ]
                ]
            ]);
        }
    }
}
