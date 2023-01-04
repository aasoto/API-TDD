<?php

namespace App\Traits;

use App\Models\Employee;
use App\Models\InterceptionEmployeeProject;
use App\Models\Project;

trait InterceptionTrait {

    public function intercepted_employee_project (Project $project, Employee $employee)
    {
        $exists = InterceptionEmployeeProject::where('project_id', $project->id)
                    ->where('employee_id', $employee->id)
                    ->count();
        if ($exists != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function project_has_employees (Project $project)
    {
        $count = InterceptionEmployeeProject::where('project_id', $project->id)->count();

        if ($count != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function employee_has_projects (Employee $employee)
    {
        $count = InterceptionEmployeeProject::where('employee_id', $employee->id)->count();

        if ($count != 0) {
            return true;
        } else {
            return false;
        }
    }

}
