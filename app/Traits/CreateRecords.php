<?php

namespace App\Traits;

use App\Models\ContractorCompany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Funciones para crear registros de manera automatica
 * Pseudo-Seeder
 */
trait CreateRecords
{

    public function if_db_is_empty ($num = 0) {
        $total_contractors = count(ContractorCompany::get());

        if ($total_contractors == 0) {
            ContractorCompany::factory()->count($num)->create();
        }
    }

    public function if_db_is_empty_get_random_record ($num = 0) {
        $total_contractors = count(ContractorCompany::get());

        if ($total_contractors > 0) {
            $contractor = ContractorCompany::inRandomOrder()->first();
        } else {
            ContractorCompany::factory()->count($num)->create();
            $contractor = ContractorCompany::inRandomOrder()->first();
        }

        return $contractor;
    }
}
