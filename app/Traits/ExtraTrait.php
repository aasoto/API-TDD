<?php

namespace App\Traits;

trait ExtraTrait {

    public function random_months ()
    {
        return fake()->randomElement(['+1 month', '+2 month', '+3 month', '+4 month', '+5 month', '+6 month', '+7 month', '+8 month']);
    }

}
