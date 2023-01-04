<?php

namespace App\Traits;

use App\Models\ContractorCompany;

trait ContractorCompanyTrait {

    public function random_contractor_company ()
    {
        $random_contractor_company = ContractorCompany::inRandomOrder()->first();
        return $random_contractor_company->id;
    }

}
