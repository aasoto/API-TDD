<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractorCompany extends Model
{
    use HasFactory;

    protected $table = 'contractor_company';

    protected $fillable = [
        'nit',
        'business_name',
        'address',
        'country_id',
        'tags',
        'responsable',
        'email',
        'phone'
    ];
}
