<?php

namespace App\Traits;

use App\Models\Country;

trait CountryTrait {

    public function random_country ()
    {
        $random_country = Country::inRandomOrder()->first();
        return $random_country->id;
    }

}
