<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_execution',
        'end_execution',
        'contractor_company_id'
    ];

    public function contractor_company ()
    {
        return $this->belongsTo(ContractorCompany::class);
    }
}
