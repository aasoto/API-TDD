<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterceptionEmployeeProject extends Model
{
    use HasFactory;

    protected $table = 'interception_employee_project';

    protected $fillable = ['employee_id', 'project_id'];

    public function employee ()
    {
        return $this->belongsTo(Employee::class);
    }

    public function project ()
    {
        return $this->belongsTo(Project::class);
    }
}
