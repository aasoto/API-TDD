<?php

namespace App\Traits;

use App\Models\ContractorCompany;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Funciones para crear registros de manera automatica
 * Pseudo-Seeder
 */
trait CreateRecords
{
    public function create_employees ($num = 0) {
        $total_employees = count(Employee::get());

        if ($total_employees == 0) {
            Employee::factory()->count($num)->create();
        }
    }

    public function create_and_get_employees ($num = 0) {
        $total_employees = count(Employee::get());

        if ($total_employees > 0) {
            $employee = Employee::inRandomOrder()->first();
        } else {
            Employee::factory()->count($num)->create();
            $employee = Employee::inRandomOrder()->first();
        }

        return $employee;
    }

    public function create_contractors_companies ($num = 0) {
        $total_contractors = count(ContractorCompany::get());

        if ($total_contractors == 0) {
            ContractorCompany::factory()->count($num)->create();
        }
    }

    public function create_and_get_contractors_companies ($num = 0) {
        $total_contractors = count(ContractorCompany::get());

        if ($total_contractors > 0) {
            $contractor = ContractorCompany::inRandomOrder()->first();
        } else {
            ContractorCompany::factory()->count($num)->create();
            $contractor = ContractorCompany::inRandomOrder()->first();
        }

        return $contractor;
    }

    public function create_projects ($num = 0) {
        $total_projects = Project::count();

        if ($total_projects == 0) {
            Project::factory()->count($num)->create();
        }
    }

    public function create_and_get_projects ($num = 0) {
        $total_projects = Project::count();

        if ($total_projects > 0) {
            $project = Project::inRandomOrder()->first();
        } else {
            Project::factory()->count($num)->create();
            $project = Project::inRandomOrder()->first();
        }

        return $project;
    }
}
